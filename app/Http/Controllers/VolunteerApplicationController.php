<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Program;
use App\Models\UserRole;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use App\Models\VolunteerApplication;
use Illuminate\Support\Facades\Auth;

class VolunteerApplicationController extends Controller
{

    public function volunteerForm()
    {
        return view('volunteers.form');
    }


    public function store(Request $request)
{
    // Validate the incoming request data
    $validated = $request->validate([
        'why_volunteer' => 'nullable|string|max:500',
        'interested_programs' => 'nullable|string|max:255',
        'skills_experience' => 'nullable|string|max:255',
        'availability' => 'nullable|string|max:255',
        'commitment_hours' => 'nullable|string|max:255',
        'physical_limitations' => 'nullable|string|max:255',
        'emergency_contact' => 'nullable|string|max:255',
        'contact_consent' => 'required|in:yes,no',
        'volunteered_before' => 'required|in:yes,no',
        'outdoor_ok' => 'required|in:yes,no,depends',
        'short_bio' => 'nullable|string|max:500',
    ]);

    // Ensure the authenticated user has a Volunteer profile
    $user = Auth::user();
    $volunteer = $user->volunteer;

    if (!$volunteer) {
        $volunteer = new Volunteer();
        $volunteer->user_id = $user->id;
        $volunteer->save();
    }

    // Create the volunteer application
    VolunteerApplication::create([
        'volunteer_id' => $volunteer->id,
        'why_volunteer' => $validated['why_volunteer'] ?? null,
        'interested_programs' => $validated['interested_programs'] ?? null,
        'skills_experience' => $validated['skills_experience'] ?? null,
        'availability' => $validated['availability'] ?? null,
        'commitment_hours' => $validated['commitment_hours'] ?? null,
        'physical_limitations' => $validated['physical_limitations'] ?? null,
        'emergency_contact' => $validated['emergency_contact'] ?? null,
        'contact_consent' => $validated['contact_consent'],
        'volunteered_before' => $validated['volunteered_before'],
        'outdoor_ok' => $validated['outdoor_ok'],
        'short_bio' => $validated['short_bio'] ?? null,
        'submitted_at' => now(),
        'is_active' => true,
    ]);

    // Assign the "Volunteer" role to the user if not already assigned
    $volunteerRole = Role::where('role_name', 'Volunteer')->first();
    if ($volunteerRole && !UserRole::where('user_id', $user->id)->where('role_id', $volunteerRole->id)->exists()) {
        UserRole::create([
            'user_id' => $user->id,
            'role_id' => $volunteerRole->id,
            'assigned_by' => $user->id,
        ]);
    }

    return redirect()->route('programs.index')->with('success', 'Application submitted successfully! Wait for the confirmation.');
}

}
