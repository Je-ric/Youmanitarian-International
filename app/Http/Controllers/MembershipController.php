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
use Illuminate\Support\Facades\Auth;

class MembershipController extends Controller
{
    // finance/membership_payments.blade.php (main)
    public function index(Request $request)
    {
        // Year filter (2023-2030)
        $year = (int)$request->get('year', now()->year);
        if ($year < 2023 || $year > 2030) {
            $year = now()->year;
        }

        $currentTab = $request->get('tab', 'overview');
        $search     = $request->get('search');
        $sortBy     = $request->get('sort_by', 'name');
        $sortOrder  = $request->get('sort_order', 'asc');
        $page       = $request->get('page', 1);

        // Full Pledge
        $fullPledgeQuery = Member::with(['user','payments' => function($q) use ($year) {
                $q->where('payment_year', $year);
            }])
            ->where('membership_status','active')
            ->where('membership_type','full_pledge');

        // Honorary
        $honoraryQuery = Member::with(['user','payments' => function($q) use ($year) {
                $q->where('payment_year', $year);
            }])
            ->where('membership_status','active')
            ->where('membership_type','honorary');

        if ($search) {
            $fullPledgeQuery->whereHas('user', fn($q)=>$q->where('name','like',"%{$search}%"));
            $honoraryQuery->whereHas('user', fn($q)=>$q->where('name','like',"%{$search}%"));
        }

        if (in_array($sortBy, ['name','email'])) {
            $fullPledgeQuery->join('users','members.user_id','=','users.id')
                ->orderBy("users.$sortBy",$sortOrder)
                ->select('members.*');
            $honoraryQuery->join('users','members.user_id','=','users.id')
                ->orderBy("users.$sortBy",$sortOrder)
                ->select('members.*');
        } else {
            $fullPledgeQuery->orderBy($sortBy,$sortOrder);
            $honoraryQuery->orderBy($sortBy,$sortOrder);
        }

        $fullPledgeMembers = $fullPledgeQuery
            ->paginate(10, ['*'], 'full_pledge_page', $currentTab === 'full_pledge' ? $page : 1);
        $honoraryMembers = $honoraryQuery
            ->paginate(10, ['*'], 'honorary_page', $currentTab === 'honorary' ? $page : 1);

        // Append params (include year)
        $fullPledgeMembers->appends([
            'tab'=>'full_pledge','search'=>$search,'sort_by'=>$sortBy,'sort_order'=>$sortOrder,'year'=>$year
        ]);
        $honoraryMembers->appends([
            'tab'=>'honorary','search'=>$search,'sort_by'=>$sortBy,'sort_order'=>$sortOrder,'year'=>$year
        ]);

        // Metrics (scoped to selected year)
        $totalMembers            = Member::count();
        $activeMembers           = Member::where('membership_status','active')->count();
        $totalPayments           = MembershipPayment::where('payment_year',$year)->count();
        $totalMembershipRevenue  = MembershipPayment::where('payment_year',$year)
            ->where('payment_status','paid')->sum('amount');
        $overduePayments         = MembershipPayment::where('payment_year',$year)
            ->where('payment_status','overdue')->count();

        // Quarterly breakdown for selected year
        $paymentStatusByQuarter = [];
        $quarters = ['Q1','Q2','Q3','Q4'];
        $statuses = ['paid','pending','overdue'];
        foreach ($quarters as $qtr) {
            foreach ($statuses as $st) {
                $paymentStatusByQuarter[$qtr][$st] = MembershipPayment::where('payment_period',$qtr)
                    ->where('payment_year',$year)
                    ->where('payment_status',$st)
                    ->count();
            }
        }

        $yearOptions = range(2023,2030);

        return view('finance.membership_payments', compact(
            'fullPledgeMembers',
            'honoraryMembers',
            'totalMembers',
            'activeMembers',
            'totalPayments',
            'paymentStatusByQuarter',
            'totalMembershipRevenue',
            'overduePayments',
            'search',
            'sortBy',
            'sortOrder',
            'year',
            'yearOptions'
        ));
    }

    private function getDueDate($quarter, $year = null)
    {
        // - Each quarter is represented as 'Q1', 'Q2', 'Q3', or 'Q4'.
        // - The due date for a quarter is set to the last day of that quarter.
        //     Q1 (Jan-Mar): due date is Mar 31
        //     Q2 (Apr-Jun): due date is Jun 30
        //     Q3 (Jul-Sep): due date is Sep 30
        //     Q4 (Oct-Dec): due date is Dec 31
        // - This ensures that for any given quarter, the payment is expected by the end of that quarter.
        $year = $year ?? now()->year;
        $quarterNumber = (int) substr($quarter, 1);

        // Set due date to the last day of the quarter
        return Carbon::create($year, $quarterNumber * 3, 1)
            ->endOfMonth();
    }

    // finance/membership_payments.blade.php (main)
    public function determinePaymentStatus($quarter, $payment)
    {
        if (!$payment) {
            return 'pending';
        }
        //
        if ($payment->payment_status === 'paid') {
            return 'paid';
        }
        // if not paid, check if it's overdue
        $dueDate = $this->getDueDate($quarter, $payment->payment_year);
        return now()->isAfter($dueDate) ? 'overdue' : 'pending';
    }

    // finance/modals/addPaymentModal.blade.php (partial)
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
            // overwrite if payment is pending, overdue, or a virtual/blank record
            $isVirtual = $existingPayment->amount == 0 && $existingPayment->notes === 'Virtual payment record created for reminder';
            $canOverwrite = $existingPayment->payment_status === 'pending' || $existingPayment->payment_status === 'overdue' || $isVirtual;

            if ($canOverwrite) {
                $data = $request->except('receipt');
                $data['payment_status'] = 'paid';
                $data['recorded_by'] = Auth::id();

                if ($request->hasFile('receipt')) {
                    $file = $request->file('receipt');
                    $sanitizedName = preg_replace('/[^A-Za-z0-9\-]/', '', $member->user->name);
                    $quarter = $request->payment_period;
                    $year = $request->payment_year;
                    $timestamp = time();
                    $extension = $file->getClientOriginalExtension();
                    $newFilename = "{$sanitizedName}_{$quarter}_{$year}_{$timestamp}.{$extension}";
                    $storagePath = $file->storeAs('uploads/membership_proof', $newFilename, 'public');
                    $data['receipt_url'] = $storagePath;
                }

                $existingPayment->update($data);

                return back()->with('toast', [
                    'type' => 'success',
                    'message' => 'Payment updated successfully.'
                ]);
            } else {
                // If payment is already paid
                return back()->with('toast', [
                    'type' => 'error',
                    'message' => 'A payment for this period already exists and is marked as paid.'
                ]);
            }
        } else {
            // If no payment exists, create a new one
            $data = $request->except('receipt');
            $data['payment_status'] = 'paid';
            $data['recorded_by'] = Auth::id();

            if ($request->hasFile('receipt')) {
                $file = $request->file('receipt');
                $sanitizedName = preg_replace('/[^A-Za-z0-9\-]/', '', $member->user->name);
                $quarter = $request->payment_period;
                $year = $request->payment_year;
                $timestamp = time();
                $extension = $file->getClientOriginalExtension();
                $newFilename = "{$sanitizedName}_{$quarter}_{$year}_{$timestamp}.{$extension}";
                $storagePath = $file->storeAs('uploads/membership_proof', $newFilename, 'public');
                $data['receipt_url'] = $storagePath;
            }
             // [MemberName]_[Quarter]_[Year]_[timestamp].jpg
            // JericDelaCruz_Q2_2025_1717581234.jpg

            $member->payments()->create($data);

            return back()->with('toast', [
                'type' => 'success',
                'message' => 'Payment recorded successfully.'
            ]);
        }
    }

    // finance/membership_payments.blade.php (main)
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
