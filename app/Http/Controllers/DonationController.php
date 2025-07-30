<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\MembershipPayment;
use Illuminate\Support\Facades\Auth;

class DonationController extends Controller
{
    // finance/donations.blade.php (main)
    public function index()
    {
        $totalConfirmedDonations = Donation::where('status', 'Confirmed')->sum('amount');
        $confirmedDonations = Donation::where('status', 'Confirmed')->count();
        $totalPendingDonations = Donation::where('status', 'Pending')->sum('amount');
        $pendingDonations = Donation::where('status', 'Pending')->count();
        $donations = Donation::latest()->paginate(10);

        return view('finance.donations', compact(
            'totalConfirmedDonations',
            'confirmedDonations',
            'totalPendingDonations',
            'pendingDonations',
            'donations'
        ));
    }

    // finance/donations.blade.php (main)
    public function updateDonationStatus(Donation $donation)
    {
        // Still undecided kung magdadagdag pa ng status na Decline? Rejected? Cancelled?
        // Ang purpose lang naman kase pag confirm is indicator na talagang nareceived na yung donation.
        $donation->update([
            'status' => 'Confirmed',
            'confirmed_at' => now(),
            'recorded_by' => Auth::id(),
        ]);
        return redirect()->back()->with('toast', [
            'message' => 'Donation status updated successfully!',
            'type' => 'success',
        ]);
    }

    // finance/modals/addDonationModal.blade.php (partial)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'donor_name' => 'nullable|string|max:255',
            'donor_email' => [
                'nullable',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if ($value && $value !== 'N/A' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        $fail('The email must be either "N/A" or a valid email address.');
                    } // dapat real-time (sana malaman - frontend side)
                },
            ],
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string|max:100',
            'donation_date' => 'required|date',
            'receipt' => 'nullable|file|mimes:jpeg,png,jpg,pdf|max:10240',
            'is_anonymous' => 'nullable|boolean',
            'notes' => 'nullable|string|max:1000',
        ]);

        $receiptPath = null;
        if ($request->hasFile('receipt')) {
            $file = $request->file('receipt');
            $sanitizedName = preg_replace('/[^A-Za-z0-9\-]/', '', $validated['donor_name'] ?? 'Anonymous');
            $dateString = date('Ymd', strtotime($validated['donation_date']));
            $timestamp = time();
            $extension = $file->getClientOriginalExtension();
            $newFilename = "{$sanitizedName}_{$dateString}_{$timestamp}.{$extension}";
            $receiptPath = $file->storeAs('uploads/donation_proof', $newFilename, 'public');
        }
        // [DonorName]_[YYYYMMDD]_[timestamp].jpg
        // JericDelaCruz_20240605_1717581234.jpg

        Donation::create([
            'donor_name' => $validated['donor_name'] ?? null,
            'donor_email' => $validated['donor_email'] ?? null,
            'amount' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'donation_date' => $validated['donation_date'],
            'receipt_url' => $receiptPath,
            'status' => 'Pending',
            'recorded_by' => Auth::id(), // wala munang confirmed_at (its in the updateDonationStatus)
            'is_anonymous' => $request->boolean('is_anonymous', false),
            'notes' => $validated['notes'] ?? null,
        ]);// Pending status are donations that have been reported/entered not yet verified or received.

        return redirect()->route('finance.index')->with('toast', [
            'message' => 'Donation added successfully!',
            'type' => 'success',
        ]);
    }
}
