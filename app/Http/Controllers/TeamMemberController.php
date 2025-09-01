<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\Request;

class TeamMemberController extends Controller
{
    public function index()
    {
        $teamMembers = TeamMember::orderBy('order')->get();
        return view('content.dynamic.teamMembers', compact('teamMembers'));
    }

    public function create()
    {
        return view('content.teamMembers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'photo_url' => 'nullable|string|max:255',
            'short_bio' => 'nullable|string|max:255',
            'full_bio' => 'nullable|string',
            'role_type' => 'nullable|string',
            'facebook_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        TeamMember::create($data);

        return redirect()->route('content.teamMembers.index')
                ->with('success', 'Team member created successfully!');
    }

    public function show(TeamMember $teamMember)
    {
        return view('content.teamMembers.show', compact('teamMember'));
    }

    public function edit(TeamMember $teamMember)
    {
        return view('content.teamMembers.edit', compact('teamMember'));
    }

    public function update(Request $request, TeamMember $teamMember)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'photo_url' => 'nullable|string|max:255',
            'short_bio' => 'nullable|string|max:255',
            'full_bio' => 'nullable|string',
            'role_type' => 'nullable|string',
            'facebook_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $teamMember->update($data);

        return redirect()->route('content.teamMembers.index')->with('success', 'Team member updated successfully!');
    }

    public function destroy(TeamMember $teamMember)
    {
        $teamMember->delete();
        return redirect()->route('content.teamMembers.index')->with('success', 'Team member deleted successfully!');
    }
}
