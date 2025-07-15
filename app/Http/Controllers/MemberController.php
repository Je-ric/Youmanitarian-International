<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\User;
use App\Models\Volunteer;
use App\Models\MembershipPayment;
use App\Models\Role;
use App\Mail\MemberInvitation;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use App\Notifications\MemberInvited;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->input('tab', 'overview');

        $members = Member::with(['user', 'volunteer'])->latest()->paginate(10, ['*'], 'overview_page');
        
        $fullPledgeMembers = Member::with(['user', 'volunteer'])
            ->where('membership_type', 'full_pledge')
            ->latest()
            ->paginate(10, ['*'], 'full_pledge_page');
            
        $honoraryMembers = Member::with(['user', 'volunteer'])
            ->where('membership_type', 'honorary')
            ->latest()
            ->paginate(10, ['*'], 'honorary_page');

        $pendingMembers = Member::with(['user', 'volunteer'])
            ->where('invitation_status', 'pending')
            ->latest()
            ->paginate(10, ['*'], 'pending_page');

        $totalMembersCount = Member::count();
        $activeMembersCount = Member::where('membership_status', 'active')->count();
        $fullPledgeMembersCount = Member::where('membership_type', 'full_pledge')->count();
        $honoraryMembersCount = Member::where('membership_type', 'honorary')->count();

        $recentlyJoinedMembers = Member::with('user')
            ->where('membership_status', 'active')
            ->latest('start_date')
            ->take(5)
            ->get();

        $oldestPendingInvitations = Member::with('user')
            ->where('invitation_status', 'pending')
            ->oldest('invited_at')
            ->take(5)
            ->get();
        
        $users = User::whereNotIn('id', function($query) {
            $query->select('user_id')->from('members');
        })->get();

        $volunteers = Volunteer::with('user')->get();

        return view('member.index', compact(
            'members',
            'fullPledgeMembers',
            'honoraryMembers',
            'pendingMembers',
            'recentlyJoinedMembers',
            'oldestPendingInvitations',
            'totalMembersCount',
            'activeMembersCount',
            'fullPledgeMembersCount',
            'honoraryMembersCount',
            'users',
            'volunteers',
            'tab'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'volunteer_id' => 'required|exists:volunteers,id',
            'membership_type' => 'required|in:full_pledge,honorary',
            // 'board_invited' => 'boolean',
            'invitation_message' => 'nullable|string|max:500',
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
                // 'board_invited' => $request->board_invited ?? false
            ]);

            $invitationMessage = $request->invitation_message;
            $member->user->notify(new MemberInvited($member, $invitationMessage));

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

            return redirect()->route('members.index')
                ->with('toast', ['type' => 'success', 'message' => 'Member created successfully and invitation sent!']);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Member creation failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput()
                ->with('toast', ['type' => 'error', 'message' => 'Failed to create member. Please try again.']);
        }
    }

    public function updateStatus(Member $member, Request $request)
    {
        $validated = $request->validate([
            'membership_status' => 'required|in:active,inactive'
        ]);

        $member->update($validated);
        
        return redirect()->back()
            ->with('toast', ['type' => 'success', 'message' => 'Member status updated successfully']);
    }

    public function invite(Request $request, Volunteer $volunteer)
    {
        try {
            $request->validate([
                'membership_type' => 'required|in:full_pledge,honorary',
                'invitation_message' => 'nullable|string|max:500',
            ]);

            $volunteer->load('user');

            if (!$volunteer->user) {
                Log::error('User not found for volunteer', [
                    'volunteer_id' => $volunteer->id
                ]);
                return redirect()->back()
                    ->with('toast', ['type' => 'error', 'message' => 'Error: User not found for this volunteer.']);
            }

            if ($volunteer->user->member) {
                return redirect()->back()
                    ->with('toast', ['type' => 'error', 'message' => 'This volunteer is already a member.']);
            }

            // Create member record
            $member = Member::create([
                'user_id' => $volunteer->user_id,
                'volunteer_id' => $volunteer->id,
                'membership_type' => $request->membership_type,
                'membership_status' => 'inactive',
                'invitation_status' => 'pending',
                'invited_at' => now(),
            ]);

            $invitationMessage = $request->invitation_message;
            $member->user->notify(new MemberInvited($member, $invitationMessage));

            // Send invitation email
            try {
                Mail::to($member->user->email)->send(new MemberInvitation($member));
                
                Log::info('Member invitation email sent successfully', [
                    'member_id' => $member->id,
                    'user_email' => $member->user->email
                ]);

                return redirect()->back()
                    ->with('toast', ['type' => 'success', 'message' => 'Member invitation sent successfully']);
            } catch (\Exception $e) {
                Log::error('Failed to send invitation email', [
                    'error' => $e->getMessage(),
                    'member_id' => $member->id,
                    'user_email' => $member->user->email
                ]);
                
                return redirect()->back()
                    ->with('toast', ['type' => 'warning', 'message' => 'Member created but failed to send invitation email. Please try sending the invitation again.']);
            }
        } catch (\Exception $e) {
            Log::error('Error in member invitation process', [
                'error' => $e->getMessage(),
                'volunteer_id' => $volunteer->id
            ]);
            
            return redirect()->back()
                ->with('toast', ['type' => 'error', 'message' => 'Error creating member. Please try again.']);
        }
    }

    public function acceptInvitation(Member $member)
    {
        try {
            DB::beginTransaction();

            $member->update([
                'membership_status' => 'active',
                'invitation_status' => 'accepted',
                'start_date' => now()
            ]);

            // Assign Member role if not already assigned
            $memberRole = Role::where('role_name', 'Member')->first();
            if ($memberRole && !$member->user->hasRole('Member')) {
                $member->user->roles()->attach($memberRole->id, [
                    'assigned_by' => null,
                    'assigned_at' => now()
                ]);
            }

            DB::commit();

            return redirect()->route('dashboard')
                ->with('toast', ['type' => 'success', 'message' => 'You have successfully accepted the membership invitation!']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('dashboard')
                ->with('toast', ['type' => 'error', 'message' => 'Failed to accept membership invitation. Please try again.']);
        }
    }

    public function declineInvitation(Member $member)
    {
        $member->update([
            'membership_status' => 'inactive',
            'invitation_status' => 'declined'
        ]);

        return redirect()->route('dashboard')
            ->with('toast', ['type' => 'info', 'message' => 'You have declined the membership invitation.']);
    }

    public function resendInvitation(Member $member)
    {
        if ($member->isActive()) {
            return redirect()->back()
                ->with('toast', ['type' => 'error', 'message' => 'Cannot resend invitation to an active member.']);
        }

        try {
            $member->update([
                'invitation_status' => 'pending',
                'invited_at' => now(),
            ]);

            // send also notif
            $member->user->notify(new MemberInvited($member));

            // Send email
            Mail::to($member->user->email)->send(new MemberInvitation($member));
            
            Log::info('Member invitation resent successfully', [
                'member_id' => $member->id,
                'user_email' => $member->user->email
            ]);

            return redirect()->back()
                ->with('toast', ['type' => 'success', 'message' => 'Invitation resent successfully.']);
        } catch (\Exception $e) {
            Log::error('Failed to resend invitation', [
                'error' => $e->getMessage(),
                'member_id' => $member->id
            ]);

            return redirect()->back()
                ->with('toast', ['type' => 'error', 'message' => 'Failed to resend invitation. Please try again.']);
        }
    }

    public function showInvitation(Member $member)
    {
        // if ($member->status !== 'invited') {
        //     abort(404, 'Invitation not found or has already been responded to.');
        // }

        // Generate signed URLs
        $acceptUrl = URL::temporarySignedRoute(
            'member.invitation.accept', now()->addDays(7), ['member' => $member->id]
        );
        $declineUrl = URL::temporarySignedRoute(
            'member.invitation.decline', now()->addDays(7), ['member' => $member->id]
        );

        $invitationMessage = "You have been invited to join as a member.";

        return view('notifications.show-invitation', compact('member', 'acceptUrl', 'declineUrl', 'invitationMessage'));
    }
}
