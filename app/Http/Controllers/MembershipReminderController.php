<?php

namespace App\Http\Controllers;

use App\Models\MembershipPayment;
use App\Models\PaymentReminder;
use App\Notifications\PaymentReminder as PaymentReminderNotification;
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
            'status' => 'sent' 
        ]);

        $memberUser = $payment->member->user;
        $memberUser->notify(new PaymentReminderNotification($reminder));
        
        return back()->with('success', 'Payment reminder has been sent.');
    }
} 