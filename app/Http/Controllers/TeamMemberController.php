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

    public function show(TeamMember $teamMember)
    {
        return view('content.teamMembers.show', compact('teamMember'));
    }

    public function edit(TeamMember $teamMember)
    {
        return view('content.teamMembers.edit', compact('teamMember'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:10240',
            'bio' => 'nullable|string|max:255',
            'facebook_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        // Ensure boolean cast with default false
        $data['is_active'] = $request->boolean('is_active');

        $this->handlePhotoUpload($request, $data);

        TeamMember::create($data);

        return redirect()->route('content.teamMembers.index')->with('toast', [
                'message' => 'Team member created successfully!',
                'type' => 'success'
        ]);
    }

    public function update(Request $request, TeamMember $teamMember)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:10240',
            'bio' => 'nullable|string|max:255',
            'facebook_url' => 'nullable|url',
            'linkedin_url' => 'nullable|url',
            'twitter_url' => 'nullable|url',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        // Ensure boolean cast with default false
        $data['is_active'] = $request->boolean('is_active');

        $this->handlePhotoUpload($request, $data);

        $teamMember->update($data);

            return redirect()->route('content.teamMembers.index')->with('toast', [
                'message' => 'Team member updated successfully!',
                'type' => 'success'
        ]);
    }

    public function destroy(TeamMember $teamMember)
    {
        $teamMember->delete();
        return redirect()->route('content.teamMembers.index')->with('toast', [
                'message' => 'Team member deleted successfully!',
                'type' => 'success'
        ]);
    }

    // ----------------------------
    //  Helper Methods
    // ----------------------------
    private function handlePhotoUpload($request, &$data) {
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $sanitizedName = preg_replace('/[^A-Za-z0-9]/', '', $data['name']);
            $sanitizedPosition = preg_replace('/[^A-Za-z0-9]/', '', $data['position'] ?? 'Member');
            $timestamp = time();
            $extension = $file->getClientOriginalExtension();
            $newFilename = "{$sanitizedName}_{$sanitizedPosition}_{$timestamp}.{$extension}";
            $data['photo_url'] = $file->storeAs('uploads/team_members', $newFilename, 'public');
        }
    }
}
