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
            'donor_email' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if ($value !== 'N/A' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $fail('The email must be either "N/A" or a valid email address.');
                    }
                },
            ],
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string|max:100',
            'donation_date' => 'required|date',
            'receipt' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:10240',
        ]);

        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            $sanitizedName = preg_replace('/[^A-Za-z0-9\-]/', '', $validated['donor_name']);
            $dateString = date('Ymd', strtotime($validated['donation_date']));
            $timestamp = time();
            $extension = $file->getClientOriginalExtension();
            $newFilename = "{$sanitizedName}_{$dateString}_{$timestamp}.{$extension}";
            $receiptPath = $file->storeAs('uploads/donation_proof', $newFilename, 'public');
        } 
        // [DonorName]_[YYYYMMDD]_[timestamp].jpg
        // JericDelaCruz_20240605_1717581234.jpg
        
        Donation::create([
            'donor_name' => $validated['donor_name'],
            'donor_email' => $validated['donor_email'],
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'donation_date' => $validated['donation_date'],
            'receipt_url' => $receiptPath,
            'status' => 'Pending',
        ]);
        // Pending status are donations that have been reported/entered but not yet verified or received.

        return redirect()->route('finance.index')->with('success', 'Donation added successfully!');
    }
}
