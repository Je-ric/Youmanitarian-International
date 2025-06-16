<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MembershipPayment;

class MembershipController extends Controller
{
    public function index()
    {
        $payments = MembershipPayment::with('member.user')
            ->latest()
            ->paginate(10);
        $members = \App\Models\Member::with('user')->get();
        return view('finance.membership', compact('payments', 'members'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'amount' => 'required|numeric|min:0',
            'payment_period' => 'required|in:Q1,Q2,Q3,Q4',
            'payment_year' => 'required|integer|min:2000',
            'receipt_url' => 'nullable|url'
        ]);

        $payment = MembershipPayment::create([
            ...$validated,
            'payment_status' => 'Paid',
            'payment_date' => now()
        ]);

        return redirect()->back()->with('success', 'Payment recorded successfully');
    }

    public function updateStatus(MembershipPayment $payment, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:Paid,Pending,Overdue'
        ]);

        $payment->update($validated);
        return redirect()->back()->with('success', 'Payment status updated successfully');
    }
}
