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
use Illuminate\Support\Facades\URL;

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
        return view('finance.members', compact('members', 'users', 'volunteers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'volunteer_id' => 'required|exists:volunteers,id',
            'membership_type' => 'required|in:full_pledge,honorary',
            'board_invited' => 'boolean'
        ]);

        try {
            DB::beginTransaction();

            $member = Member::create([
                'user_id' => $request->user_id,
                'volunteer_id' => $request->volunteer_id,
                'membership_type' => $request->membership_type,
                'membership_status' => 'inactive',
                'invitation_status' => 'pending',
                'invited_at' => now(),
                'invitation_expires_at' => now()->addDays(7),
                'board_invited' => $request->board_invited ?? false
            ]);

            // Send invitation email
            try {
                Mail::to($member->user->email)->send(new MemberInvitation($member));
                Log::info('Member invitation email sent successfully', [
                    'member_id' => $member->id,
                    'email' => $member->user->email
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send member invitation email', [
                    'error' => $e->getMessage(),
                    'member_id' => $member->id,
                    'email' => $member->user->email
                ]);
            }

            DB::commit();

            return redirect()->route('finance.members')
                ->with('success', 'Member created successfully and invitation sent!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Member creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create member. Please try again.');
        }
    }

    public function updateStatus(Member $member, Request $request)
    {
        $validated = $request->validate([
            'membership_status' => 'required|in:active,inactive'
        ]);

        $member->update($validated);
        
        return redirect()->back()
            ->with('success', 'Member status updated successfully');
    }

    public function invite(Volunteer $volunteer)
    {
        try {
            $volunteer->load('user');

            if (!$volunteer->user) {
                Log::error('User not found for volunteer', [
                    'volunteer_id' => $volunteer->id
                ]);
                return redirect()->back()
                    ->with('error', 'Error: User not found for this volunteer.');
            }

            if ($volunteer->user->member) {
                return redirect()->back()
                    ->with('error', 'This volunteer is already a member.');
            }

            // Create member record
            $member = Member::create([
                'user_id' => $volunteer->user_id,
                'volunteer_id' => $volunteer->id,
                'membership_type' => 'full_pledge',
                'membership_status' => 'inactive',
                'invitation_status' => 'pending',
                'invited_at' => now(),
                'invitation_expires_at' => now()->addDays(7)
            ]);

            // Send invitation email
            try {
                Mail::to($member->user->email)->send(new MemberInvitation($member));
                
                Log::info('Member invitation email sent successfully', [
                    'member_id' => $member->id,
                    'user_email' => $member->user->email
                ]);

                return redirect()->back()
                    ->with('success', 'Member invitation sent successfully');
            } catch (\Exception $e) {
                Log::error('Failed to send invitation email', [
                    'error' => $e->getMessage(),
                    'member_id' => $member->id,
                    'user_email' => $member->user->email
                ]);
                
                return redirect()->back()
                    ->with('warning', 'Member created but failed to send invitation email. Please try sending the invitation again.');
            }
        } catch (\Exception $e) {
            Log::error('Error in member invitation process', [
                'error' => $e->getMessage(),
                'volunteer_id' => $volunteer->id
            ]);
            
            return redirect()->back()
                ->with('error', 'Error creating member. Please try again.');
        }
    }

    public function acceptInvitation(Member $member)
    {
        if ($member->isInvitationExpired()) {
            return redirect()->route('dashboard')
                ->with('error', 'This invitation has expired. Please request a new invitation.');
        }

        $member->update([
            'membership_status' => 'active',
            'invitation_status' => 'accepted',
            'start_date' => now()
        ]);

        return redirect()->route('dashboard')
            ->with('success', 'You have successfully accepted the membership invitation!');
    }

    public function declineInvitation(Member $member)
    {
        if ($member->isInvitationExpired()) {
            return redirect()->route('dashboard')
                ->with('error', 'This invitation has expired.');
        }

        $member->update([
            'membership_status' => 'inactive',
            'invitation_status' => 'declined'
        ]);

        return redirect()->route('dashboard')
            ->with('info', 'You have declined the membership invitation.');
    }

    public function resendInvitation(Member $member)
    {
        if ($member->isActive()) {
            return redirect()->back()
                ->with('error', 'Cannot resend invitation to an active member.');
        }

        try {
            $member->update([
                'invitation_status' => 'pending',
                'invited_at' => now(),
                'invitation_expires_at' => now()->addDays(7)
            ]);

            Mail::to($member->user->email)->send(new MemberInvitation($member));
            
            Log::info('Member invitation resent successfully', [
                'member_id' => $member->id,
                'user_email' => $member->user->email
            ]);

            return redirect()->back()
                ->with('success', 'Invitation resent successfully.');
        } catch (\Exception $e) {
            Log::error('Failed to resend invitation', [
                'error' => $e->getMessage(),
                'member_id' => $member->id
            ]);

            return redirect()->back()
                ->with('error', 'Failed to resend invitation. Please try again.');
        }
    }
}
