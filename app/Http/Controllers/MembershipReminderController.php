<?php

namespace App\Http\Controllers;

use App\Models\MembershipPayment;
use App\Models\PaymentReminder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MembershipReminderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'membership_payment_id' => 'required|exists:membership_payments,id',
            'content' => 'required|string|max:1000',
        ]);

        $payment = MembershipPayment::findOrFail($request->membership_payment_id);

        $reminder = PaymentReminder::create([
            'membership_payment_id' => $payment->id,
            'sent_by_user_id' => Auth::id(),
            'content' => $request->content,
            'status' => 'sent' // You might want to change this if you implement actual email sending
        ]);

        // TODO: Implement actual reminder sending (email, notification, etc.)
        // For now, we'll just save it to the database

        return back()->with('success', 'Payment reminder has been sent.');
    }
} 