<?php

namespace App\Http\Controllers;

use App\Models\MembershipPayment;
use App\Models\PaymentReminder;
use App\Models\Member;
use App\Notifications\PaymentReminder as PaymentReminderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MembershipReminderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'membership_payment_id' => 'required',
            'content' => 'required|string|max:1000',
        ]);

        $membershipPaymentId = $request->membership_payment_id;
        
        // Check if this is a virtual payment (no actual payment record exists)
        if (str_starts_with($membershipPaymentId, 'virtual_')) {
            // Parse virtual payment info
            // Example: "virtual_Q1_2025" becomes ["virtual", "Q1", "2025"]
            $parts = explode('_', $membershipPaymentId);
            $quarter = $parts[1]; 
            $year = $parts[2];     
            
            $member = Member::findOrFail($request->member_id); // member
            
            // check if kung yung virtual payment record ay existing na
            // this is to prevent multiple duplication ng virtual payment lalo na kung same member, quarter and year
            $existingVirtualPayment = $member->payments()
                ->where('payment_period', $quarter)
                ->where('payment_year', $year)
                ->where('notes', 'Virtual payment record created for reminder')
                ->first();
            
            if ($existingVirtualPayment) {
                // use existing virtual payment record (overwrite instead of creating new record)
                $payment = $existingVirtualPayment;
            } else {
                // Create a virtual payment record for the reminder
                // kase pano tayo makakapagsend ng reminder kung walang record
                // remember each pending and overdue are blank records
                $payment = $member->payments()->create([
                    'amount' => 0, 
                    'payment_date' => now(),
                    'payment_status' => 'pending',
                    'payment_method' => 'cash', 
                    'payment_period' => $quarter,
                    'payment_year' => $year,
                    'notes' => 'Virtual payment record created for reminder'
                    
                ]);
            }
        } else {
            // payment record exists - find the existing payment
            $payment = MembershipPayment::findOrFail($membershipPaymentId);
        }

        // insert reminder record in membership_payments_reminders table
        $reminder = PaymentReminder::create([
            'membership_payment_id' => $payment->id,
            'sent_by_user_id' => Auth::id(),
            'content' => $request->content,
            'status' => 'sent' 
        ]);

        // Send notification to the member \Notifications\PaymentReminder.php
        $memberUser = $payment->member->user;
        
        // Force the notification to be sent immediately
        $notification = new PaymentReminderNotification($reminder);
        $memberUser->notify($notification);
        
        return back()->with('toast', [
            'message' => 'Payment reminder sent successfully!',
            'type' => 'success'
        ]);

        // make sure both tables have data
        // $reminderCount = DB::table('membership_payments_reminders')->count();
        // $notificationCount = DB::table('notifications')
        //     ->where('notifiable_id', $memberUser->id)
        //     ->where('type', 'App\Notifications\PaymentReminder')
        //     ->count();
        
        // return back()->with('toast', [
        //     'message' => "Payment reminder sent! Reminders: {$reminderCount}, Notifications: {$notificationCount}",
        //     'type' => 'success'
        // ]);
    }

    // Get payment options for reminderModal
    public function getPaymentOptions(Member $member)
    {
        $currentYear = now()->year;
        $quarters = ['Q1', 'Q2', 'Q3', 'Q4'];
        
        // Dapat lang na makita ang quarters na dapat bayaran ng member based sa start date nila.
        // inshort magbabayad lang sila sa quarter na naabutan nila (depende pa kung mababago)
        // nakaayon sa policy ng youmanitarian
        $startYear = $member->start_date ? $member->start_date->format('Y') : null;
        $startQuarter = $member->start_date ? ceil($member->start_date->format('n') / 3) : null;
        
        // get existing payments for current year
        $existingPayments = $member->payments()->where('payment_year', $currentYear)->get();
        
        // create payment options for all quarters
        $paymentOptions = [];
        foreach ($quarters as $quarter) { 
            // Extract quarter number (1, 2, 3, 4) from quarter string (Q1, Q2, Q3, Q4)
            $quarterNumber = substr($quarter, 1); 

            // Determine if this quarter should be shown for payment
            // Show if: member started before current year OR (same year but quarter >= start quarter)
            // Examples: (note: napakahirap thanks to AI buddies)
                    // If member started in 2023 → Show all 2025 quarters
                    // If member started in Q2 2025 → Show Q2, Q3, Q4 2025
                    // If member started in Q4 2025 → Show Q4 2025 only 
            $shouldShowPayment = $startYear && 
                ($currentYear > $startYear || 
                ($currentYear == $startYear && $quarterNumber >= $startQuarter));
            
            if ($shouldShowPayment) { // if payment record already exists for this quarter
                $existingPayment = $existingPayments->where('payment_period', $quarter)->first();
                
                if ($existingPayment) { // Payment record exists - show actual payment with its status
                    $paymentOptions[] = [
                        'value' => $existingPayment->id,
                        'label' => $quarter . ' ' . $currentYear . ' (' . ucfirst($existingPayment->payment_status) . ')',
                        'is_virtual' => false
                    ];
                } else { // No payment record exists - create virtual option for unpaid quarter
                    $status = app(MembershipController::class)->determinePaymentStatus($quarter, null);
                    $paymentOptions[] = [
                        'value' => 'virtual_' . $quarter . '_' . $currentYear,
                        'label' => $quarter . ' ' . $currentYear . ' (' . ucfirst($status) . ')',
                        'is_virtual' => true,
                        'quarter' => $quarter,
                        'year' => $currentYear,
                        'status' => $status
                    ];
                }
            }
        }
        
        return $paymentOptions;
    }
} 