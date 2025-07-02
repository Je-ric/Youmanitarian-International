<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\MembershipPayment;

class DonationController extends Controller
{
    public function index()
    {
        $totalDonations = Donation::where('status', 'Confirmed')->sum('amount');
        $pendingDonations = Donation::where('status', 'Pending')->count();
        $donations = Donation::latest()->paginate(10);

        return view('finance.donations', compact(
            'totalDonations',
            'pendingDonations',
            'donations'
        ));
    }

    public function updateDonationStatus(Donation $donation)
    {
        $donation->update(['status' => 'Confirmed']);
        return redirect()->back()->with('success', 'Donation status updated successfully');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'donor_name' => 'required|string|max:255',
            'donor_email' => 'required|email|max:255',
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string|max:100',
            'donation_date' => 'required|date',
            'receipt' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:10240',
        ]);

        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            $donorName = preg_replace('/[^A-Za-z0-9\-]/', '', $validated['donor_name']);
            $date = date('Ymd', strtotime($validated['donation_date']));
            $timestamp = time();
            $extension = $file->getClientOriginalExtension();
            $filename = "{$donorName}_{$date}_{$timestamp}.{$extension}";
            $receiptPath = $file->storeAs('uploads/donation_proof', $filename, 'public');
        }

        Donation::create([
            'donor_name' => $validated['donor_name'],
            'donor_email' => $validated['donor_email'],
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'donation_date' => $validated['donation_date'],
            'receipt_url' => $receiptPath,
            'status' => 'Pending',
        ]);

        return redirect()->route('finance.index')->with('success', 'Donation added successfully!');
    }
}
