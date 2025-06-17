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

    public function determinePaymentStatus($quarter, $payment = null)
    {
        if ($payment && $payment->payment_status === 'paid') {
            return 'paid';
        }

        $currentDate = Carbon::now();
        $currentYear = $currentDate->year;
        $currentQuarter = ceil($currentDate->month / 3);
        $quarterNumber = (int) substr($quarter, 1);

        if ($quarterNumber > $currentQuarter) {
            return 'pending';
        }

        if ($quarterNumber === $currentQuarter) {
            return $payment ? $payment->payment_status : 'pending';
        }

        return 'overdue';
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'amount' => 'required|numeric|min:0',
            'payment_period' => 'required|in:Q1,Q2,Q3,Q4',
            'payment_year' => 'required|integer|min:2000|max:2100',
            'payment_method' => 'required|in:cash,bank_transfer,credit_card,paypal',
            'receipt' => 'nullable|file|mimes:jpeg,png,pdf|max:10048',
            'notes' => 'nullable|string|max:1000'
        ]);

        $member = Member::findOrFail($request->member_id);

        if (!$member->isActive()) {
            return redirect()->back()
                ->with('error', 'Cannot add payment for inactive member.');
        }

        $existingPayment = $member->payments()
            ->where('payment_period', $request->payment_period)
            ->where('payment_year', $request->payment_year)
            ->first();

        if ($existingPayment) {
            return redirect()->back()
                ->with('error', 'Payment already exists for this period.');
        }

        DB::beginTransaction();

        try {
            $payment = $member->payments()->create([
                'amount' => $validated['amount'],
                'payment_period' => $validated['payment_period'],
                'payment_year' => $validated['payment_year'],
                'payment_status' => 'paid',
                'payment_method' => $validated['payment_method'],
                'notes' => $validated['notes'] ?? null,
                'payment_date' => now()
            ]);

            if ($request->hasFile('receipt')) {
                $file = $request->file('receipt');
                $memberName = Str::slug($member->user->name);
                $fileName = sprintf(
                    'payment_%s_%s_%s_%s.%s',
                    $memberName,
                    $validated['payment_period'],
                    $validated['payment_year'],
                    time(),
                    $file->getClientOriginalExtension()
                );
                
                $path = $file->storeAs(
                    'uploads/membership_payments',
                    $fileName,
                    'public'
                );
                
                $payment->update(['receipt_url' => $path]);
            }

            DB::commit();

            Log::info('Membership payment created', [
                'payment_id' => $payment->id,
                'member_id' => $member->id,
                'amount' => $payment->amount,
                'period' => $payment->payment_period,
                'year' => $payment->payment_year,
                'status' => $payment->payment_status
            ]);

            return redirect()->back()
                ->with('success', 'Payment added successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create payment', [
                'error' => $e->getMessage(),
                'member_id' => $request->member_id,
                'period' => $request->payment_period,
                'year' => $request->payment_year
            ]);
            return redirect()->back()
                ->with('error', 'Failed to create payment. Please try again.');
        }
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

    public function showPaymentModal($memberId, $quarter, $year)
    {
        $member = Member::with('user')->findOrFail($memberId);
        $payment = $member->payments()
            ->where('payment_period', $quarter)
            ->where('payment_year', $year)
            ->first();

        $status = $payment ? $payment->payment_status : $this->determinePaymentStatus($quarter, $payment);
        $statusClass = $status === 'paid' ? 'text-green-600' : ($status === 'overdue' ? 'text-red-600' : 'text-yellow-600');

        return view('finance.modals.addPaymentModal', [
            'member' => $member,
            'quarter' => $quarter,
            'year' => $year,
            'payment' => $payment,
            'status' => $status,
            'statusClass' => $statusClass
        ]);
    }
}
