<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\User;
use App\Models\Volunteer;
use App\Models\MembershipPayment;
use App\Mail\MemberInvitation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::with(['user', 'volunteer'])
            ->latest()
            ->paginate(10);
        $users = User::whereNotIn('id', function($query) {
            $query->select('user_id')->from('members');
        })->get();
        $volunteers = Volunteer::with('user')->get();
        return view('finance.memberLists', compact('members', 'users', 'volunteers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'country' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'membership_type' => 'required|in:individual,corporate,student',
            'membership_status' => 'required|in:active,inactive,pending',
            'membership_start_date' => 'required|date',
            'membership_end_date' => 'required|date|after:membership_start_date',
            'membership_fee' => 'required|numeric|min:0',
            'payment_status' => 'required|in:paid,pending,overdue',
            'payment_method' => 'required|in:credit_card,bank_transfer,cash,other',
            'payment_date' => 'required|date',
            'payment_amount' => 'required|numeric|min:0',
            'payment_reference' => 'required|string|max:100',
            'payment_notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Create user
            $user = User::create([
                'name' => $request->first_name . ' ' . $request->last_name,
                'email' => $request->email,
                'password' => Hash::make(Str::random(12)),
                'role' => 'member'
            ]);

            // Create member
            $member = Member::create([
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'country' => $request->country,
                'postal_code' => $request->postal_code,
                'membership_type' => $request->membership_type,
                'membership_status' => $request->membership_status,
                'membership_start_date' => $request->membership_start_date,
                'membership_end_date' => $request->membership_end_date,
                'membership_fee' => $request->membership_fee,
            ]);

            // Create membership payment
            MembershipPayment::create([
                'member_id' => $member->id,
                'payment_status' => $request->payment_status,
                'payment_method' => $request->payment_method,
                'payment_date' => $request->payment_date,
                'payment_amount' => $request->payment_amount,
                'payment_reference' => $request->payment_reference,
                'payment_notes' => $request->payment_notes,
            ]);

            // Send invitation email
            try {
                Mail::to($user->email)->send(new MemberInvitation($member));
                Log::info('Member invitation email sent successfully', [
                    'member_id' => $member->id,
                    'email' => $user->email
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send member invitation email', [
                    'error' => $e->getMessage(),
                    'member_id' => $member->id,
                    'email' => $user->email
                ]);
            }

            DB::commit();

            return redirect()->route('members.index')
                ->with('toast', [
                    'type' => 'success',
                    'message' => 'Member created successfully and invitation sent!'
                ]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Member creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('toast', [
                    'type' => 'error',
                    'message' => 'Failed to create member. Please try again.'
                ]);
        }
    }

    public function updateStatus(Member $member, Request $request)
    {
        $validated = $request->validate([
            'membership_status' => 'required|in:active,inactive'
        ]);

        $member->update($validated);
        
        return redirect()->back()
            ->with('toast', [
                'type' => 'success',
                'message' => 'Member status updated successfully'
            ]);
    }

    public function invite(Volunteer $volunteer)
    {
        try {
            // Load the user relationship
            $volunteer->load('user');

            if (!$volunteer->user) {
                Log::error('User not found for volunteer', [
                    'volunteer_id' => $volunteer->id
                ]);
                return redirect()->back()
                    ->with('toast', [
                        'type' => 'error',
                        'message' => 'Error: User not found for this volunteer.'
                    ]);
            }

            if ($volunteer->user->member) {
                return redirect()->back()
                    ->with('toast', [
                        'type' => 'error',
                        'message' => 'This volunteer is already a member.'
                    ]);
            }

            Log::info('Inviting volunteer to be member', [
                'volunteer_id' => $volunteer->id,
                'user_id' => $volunteer->user_id,
                'user_email' => $volunteer->user->email
            ]);

            // Create member record first
            $member = Member::create([
                'user_id' => $volunteer->user_id,
                'volunteer_id' => $volunteer->id,
                'membership_type' => 'full_pledge',
                'membership_status' => 'inactive',
                'start_date' => now(),
                'became_member_at' => null,
                'board_invited' => false
            ]);

            // Load the user relationship
            $member->load('user');

            if (!$member->user) {
                throw new \Exception('User not found after member creation');
            }

            // Send invitation email
            try {
                Mail::to($member->user->email)->send(new MemberInvitation($member));
                
                Log::info('Member invitation email sent successfully', [
                    'member_id' => $member->id,
                    'user_email' => $member->user->email
                ]);

                return redirect()->back()
                    ->with('toast', [
                        'type' => 'success',
                        'message' => 'Member invitation sent successfully'
                    ]);
            } catch (\Exception $e) {
                Log::error('Failed to send invitation email', [
                    'error' => $e->getMessage(),
                    'member_id' => $member->id,
                    'user_email' => $member->user->email,
                    'trace' => $e->getTraceAsString()
                ]);
                
                // Member is created but email failed - still return success but with warning
                return redirect()->back()
                    ->with('toast', [
                        'type' => 'warning',
                        'message' => 'Member created but failed to send invitation email. Please try sending the invitation again.'
                    ]);
            }
        } catch (\Exception $e) {
            Log::error('Error in member invitation process', [
                'error' => $e->getMessage(),
                'volunteer_id' => $volunteer->id,
                'trace' => $e->getTraceAsString()
            ]);
            return redirect()->back()
                ->with('toast', [
                    'type' => 'error',
                    'message' => 'Error creating member. Please try again.'
                ]);
        }
    }

    public function acceptInvitation(Member $member)
    {
        $member->update([
            'membership_status' => 'active',
            'became_member_at' => now()
        ]);

        return redirect()->route('dashboard')
            ->with('toast', [
                'type' => 'success',
                'message' => 'You have successfully accepted the membership invitation!'
            ]);
    }

    public function declineInvitation(Member $member)
    {
        $member->update([
            'membership_status' => 'inactive'
        ]);

        return redirect()->route('dashboard')
            ->with('toast', [
                'type' => 'info',
                'message' => 'You have declined the membership invitation.'
            ]);
    }

    public function resendInvitation(Member $member)
    {
        try {
            // Load the user relationship
            $member->load('user');

            if (!$member->user) {
                Log::error('User not found for member', [
                    'member_id' => $member->id
                ]);
                return redirect()->back()
                    ->with('toast', [
                        'type' => 'error',
                        'message' => 'Error: User not found for this member.'
                    ]);
            }

            // Send invitation email
            Mail::to($member->user->email)->send(new MemberInvitation($member));
            
            Log::info('Member invitation email resent successfully', [
                'member_id' => $member->id,
                'user_email' => $member->user->email
            ]);

            return redirect()->back()
                ->with('toast', [
                    'type' => 'success',
                    'message' => 'Member invitation has been resent successfully'
                ]);
        } catch (\Exception $e) {
            Log::error('Failed to resend invitation email', [
                'error' => $e->getMessage(),
                'member_id' => $member->id,
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->with('toast', [
                    'type' => 'error',
                    'message' => 'Failed to resend invitation email. Please try again.'
                ]);
        }
    }
}
