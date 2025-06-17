<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Str;

class MembershipController extends Controller
{
    public function index()
    {
        $members = Member::with(['user', 'payments' => function($query) {
            $query->where('payment_year', now()->year);
        }])
        ->where('membership_status', 'active')
        ->orderBy('created_at', 'desc')
        ->paginate(10);

        return view('finance.membership_payments', compact('members'));
    }

    private function getDueDate($quarter)
    {
        $currentYear = now()->year;
        $quarterNumber = (int) substr($quarter, 1);
        
        // Set due date to the last day of the quarter
        return Carbon::create($currentYear, $quarterNumber * 3, 1)
            ->endOfMonth();
    }

    public function determinePaymentStatus($quarter, $payment)
    {
        if (!$payment) {
            return 'pending';
        }

        if ($payment->payment_status === 'paid') {
            return 'paid';
        }

        $dueDate = $this->getDueDate($quarter);
        return now()->isAfter($dueDate) ? 'overdue' : 'pending';
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'amount' => 'required|numeric|min:0',
            'payment_date' => 'required|date',
            'payment_period' => 'required|in:Q1,Q2,Q3,Q4',
            'payment_year' => 'required|integer',
            'payment_method' => 'required|in:cash,bank_transfer,credit_card,paypal',
            'receipt' => 'nullable|file|mimes:jpeg,png,pdf|max:10048',
            'notes' => 'nullable|string|max:500'
        ]);

        $member = Member::findOrFail($request->member_id);
        
        // Check if payment already exists
        $existingPayment = $member->payments()
            ->where('payment_period', $request->payment_period)
            ->where('payment_year', $request->payment_year)
            ->first();

        if ($existingPayment) {
            return back()->with('error', 'A payment for this period already exists.');
        }

        $data = $request->except('receipt');
        $data['payment_status'] = 'paid';

        if ($request->hasFile('receipt')) {
            $data['receipt_url'] = $request->file('receipt')->store('receipts', 'public');
        }

        $member->payments()->create($data);

        return back()->with('success', 'Payment recorded successfully.');
    }

    public function updateStatus(MembershipPayment $payment, Request $request)
    {
        $validated = $request->validate([
            'status' => 'required|in:paid,pending,overdue'
        ]);

        $payment->update([
            'payment_status' => $validated['status']
        ]);

        Log::info('Payment status updated', [
            'payment_id' => $payment->id,
            'new_status' => $validated['status'],
            'period' => $payment->payment_period,
            'year' => $payment->payment_year
        ]);

        return redirect()->back()
            ->with('success', 'Payment status updated successfully.');
    }
}
