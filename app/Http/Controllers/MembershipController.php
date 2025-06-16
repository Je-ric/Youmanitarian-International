<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MembershipController extends Controller
{
    public function index()
    {
        $members = Member::with(['user', 'payments' => function($query) {
            $query->where('payment_year', now()->year);
        }])
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('finance.membership', compact('members'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'amount' => 'required|numeric|min:0',
            'payment_period' => 'required|in:Q1,Q2,Q3,Q4',
            'payment_year' => 'required|integer|min:2000|max:2100',
            'receipt_url' => 'nullable|url',
            'notes' => 'nullable|string'
        ]);

        try {
            $member = Member::findOrFail($request->member_id);

            if (!$member->isActive()) {
                return redirect()->back()
                    ->with('toast', [
                        'type' => 'error',
                        'message' => 'Cannot add payment for inactive member.'
                    ]);
            }

            // Check if payment already exists for this period
            $existingPayment = $member->payments()
                ->where('payment_period', $request->payment_period)
                ->where('payment_year', $request->payment_year)
                ->first();

            if ($existingPayment) {
                return redirect()->back()
                    ->with('toast', [
                        'type' => 'error',
                        'message' => 'Payment already exists for this period.'
                    ]);
            }

            $payment = $member->payments()->create([
                'amount' => $request->amount,
                'payment_period' => $request->payment_period,
                'payment_year' => $request->payment_year,
                'payment_status' => 'paid',
                'receipt_url' => $request->receipt_url,
                'notes' => $request->notes
            ]);

            Log::info('Membership payment created', [
                'payment_id' => $payment->id,
                'member_id' => $member->id,
                'amount' => $payment->amount
            ]);

            return redirect()->back()
                ->with('toast', [
                    'type' => 'success',
                    'message' => 'Payment added successfully.'
                ]);
        } catch (\Exception $e) {
            Log::error('Failed to create membership payment', [
                'error' => $e->getMessage(),
                'member_id' => $request->member_id
            ]);

            return redirect()->back()
                ->with('toast', [
                    'type' => 'error',
                    'message' => 'Failed to add payment. Please try again.'
                ]);
        }
    }

    public function updateStatus(MembershipPayment $payment, Request $request)
    {
        $request->validate([
            'status' => 'required|in:paid,pending,overdue'
        ]);

        try {
            $payment->update([
                'payment_status' => $request->status
            ]);

            Log::info('Payment status updated', [
                'payment_id' => $payment->id,
                'new_status' => $request->status
            ]);

            return redirect()->back()
                ->with('toast', [
                    'type' => 'success',
                    'message' => 'Payment status updated successfully.'
                ]);
        } catch (\Exception $e) {
            Log::error('Failed to update payment status', [
                'error' => $e->getMessage(),
                'payment_id' => $payment->id
            ]);

            return redirect()->back()
                ->with('toast', [
                    'type' => 'error',
                    'message' => 'Failed to update payment status. Please try again.'
                ]);
        }
    }
}
