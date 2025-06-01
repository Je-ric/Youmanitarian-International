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
    $request->validate([
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

    $user = Auth::user();
    $volunteer = $user->volunteer;
    
    $volunteer = Volunteer::updateOrCreate(
        ['user_id' => $user->id],
        [
            'application_status' => 'pending',
            'joined_at' => null,
        ]
    );

      if (!$volunteer) {
        $volunteer = new Volunteer();
        $volunteer->user_id = $user->id;
        $volunteer->save();
    }

    // Create or update the application details
    $volunteer->application()->updateOrCreate(
        ['volunteer_id' => $volunteer->id],
        array_merge(
            $request->only([
                'why_volunteer',
                'interested_programs',
                'skills_experience',
                'availability',
                'commitment_hours',
                'physical_limitations',
                'emergency_contact',
                'contact_consent',
                'volunteered_before',
                'outdoor_ok',
                'short_bio',
            ]),
            [
                'submitted_at' => now(),
                'is_active' => true,
            ]
        )
    );

        // Assign the "Volunteer" role to the user if not already assigned
    $volunteerRole = Role::where('role_name', 'Volunteer')->first();
    if ($volunteerRole && !UserRole::where('user_id', $user->id)->where('role_id', $volunteerRole->id)->exists()) {
        UserRole::create([
            'user_id' => $user->id,
            'role_id' => $volunteerRole->id,
            'assigned_by' => $user->id,
        ]);
    }

    return redirect()->route('dashboard')->with('success', 'Your application has been submitted and is pending review.');
}


}
