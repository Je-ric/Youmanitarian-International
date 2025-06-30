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
        $totalMembershipPayments = MembershipPayment::where('payment_status', 'Paid')->sum('amount');
        $pendingDonations = Donation::where('status', 'Pending')->count();
        $overduePayments = MembershipPayment::where('payment_status', 'Overdue')->count();
        $donations = Donation::latest()->paginate(10);

        $totalRevenue = $totalDonations + $totalMembershipPayments;
        $donationPercentage = $totalRevenue > 0 ? round(($totalDonations / $totalRevenue) * 100) : 0;
        $membershipPercentage = $totalRevenue > 0 ? round(($totalMembershipPayments / $totalRevenue) * 100) : 0;

        return view('finance.donations', compact(
            'totalDonations',
            'totalMembershipPayments',
            'pendingDonations',
            'overduePayments',
            'donations',
            'totalRevenue',
            'donationPercentage',
            'membershipPercentage'
        ));
    }

    public function updateDonationStatus(Donation $donation)
    {
        $donation->update(['status' => 'Confirmed']);
        return redirect()->back()->with('success', 'Donation status updated successfully');
    }
}
