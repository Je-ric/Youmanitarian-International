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
        $totalMembershipPayments = MembershipPayment::where('payment_status', 'Paid')->sum('amount');
        $pendingDonations = Donation::where('status', 'Pending')->count();
        $overduePayments = MembershipPayment::where('payment_status', 'Overdue')->count();

        return view('finance.index', compact(
            'totalDonations',
            'totalMembershipPayments',
            'pendingDonations',
            'overduePayments'
        ));
    }

    public function donations()
    {
        $donations = Donation::latest()->paginate(10);
        return view('finance.donations', compact('donations'));
    }

    public function updateDonationStatus(Donation $donation)
    {
        $donation->update(['status' => 'Confirmed']);
        return redirect()->back()->with('success', 'Donation status updated successfully');
    }
}
