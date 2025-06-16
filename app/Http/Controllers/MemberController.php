<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MemberController extends Controller
{
    public function index()
    {
        $members = Member::with(['user', 'volunteer'])
            ->latest()
            ->paginate(10);
        $users = \App\Models\User::whereNotIn('id', function($query) {
            $query->select('user_id')->from('members');
        })->get();
        $volunteers = \App\Models\Volunteer::with('user')->get();
        return view('finance.memberLists', compact('members', 'users', 'volunteers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'volunteer_id' => 'required|exists:volunteers,id',
            'membership_type' => 'required|in:full_pledge,honorary',
            'board_invited' => 'boolean'
        ]);

        $member = Member::create([
            ...$validated,
            'membership_status' => 'active',
            'start_date' => now(),
            'became_member_at' => now()
        ]);

        return redirect()->back()->with('success', 'Member added successfully');
    }

    public function updateStatus(Member $member, Request $request)
    {
        $validated = $request->validate([
            'membership_status' => 'required|in:active,inactive'
        ]);

        $member->update($validated);
        return redirect()->back()->with('success', 'Member status updated successfully');
    }

    public function invite(\App\Models\Volunteer $volunteer)
    {
        // Check if volunteer is already a member
        if ($volunteer->user->member) {
            return redirect()->back()->with('error', 'This volunteer is already a member.');
        }

        // Create new member
        $member = Member::create([
            'user_id' => $volunteer->user_id,
            'volunteer_id' => $volunteer->id,
            'membership_type' => 'full_pledge',
            'membership_status' => 'active',
            'start_date' => now(),
            'became_member_at' => now(),
            'board_invited' => false
        ]);

        return redirect()->back()->with('success', 'Volunteer has been successfully invited to become a member.');
    }
}
