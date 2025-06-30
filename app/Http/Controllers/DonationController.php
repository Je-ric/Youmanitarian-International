<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donation;
use App\Models\MembershipPayment;

class DonationController extends Controller
{
    public function finance_index()
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
}
