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
            'why_volunteer' => 'required|string|max:500',
            'interested_programs' => 'required|string|max:255',
            'skills_experience' => 'nullable|string|max:255',
            'availability' => 'required|string|max:255',
            'commitment_hours' => 'required|string|max:255',
            'physical_limitations' => 'nullable|string|max:255',
            'emergency_contact' => 'required|string|max:255',
            'contact_consent' => 'required|in:yes,no',
            'volunteered_before' => 'required|in:yes,no',
            'outdoor_ok' => 'required|in:yes,no,depends',
            'short_bio' => 'nullable|string|max:500',
        ]);

        // Get the volunteer or create a new volunteer if it doesn't exist
        $volunteer = Auth::user()->volunteer;

        if (!$volunteer) {
            $volunteer = new Volunteer();
            $volunteer->user_id = Auth::id();
            $volunteer->save();
        }

        // Store data in the VolunteerApplication table
        $volunteerId = $volunteer->id;

        VolunteerApplication::create([
            'volunteer_id' => $volunteerId,
            'why_volunteer' => $request->input('why_volunteer'),
            'interested_programs' => $request->input('interested_programs'),
            'skills_experience' => $request->input('skills_experience'),
            'availability' => $request->input('availability'),
            'commitment_hours' => $request->input('commitment_hours'),
            'physical_limitations' => $request->input('physical_limitations'),
            'emergency_contact' => $request->input('emergency_contact'),
            'contact_consent' => $request->input('contact_consent'),
            'volunteered_before' => $request->input('volunteered_before'),
            'outdoor_ok' => $request->input('outdoor_ok'),
            'short_bio' => $request->input('short_bio'),
            'submitted_at' => now(),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Assign Volunteer role to the user if they don't already have it
        $volunteerRole = Role::where('role_name', 'Volunteer')->first();
        if ($volunteerRole && !UserRole::where('user_id', Auth::id())->where('role_id', $volunteerRole->id)->exists()) {
            UserRole::create([
                'user_id' => Auth::id(),
                'role_id' => $volunteerRole->id,
                'assigned_by' => Auth::id(),
            ]);
        }

        // Redirect back with success message
        return redirect()->route('programs.index')->with('success', 'Your application has been submitted successfully, and your role is now Volunteer!');
    }

    public function proceedApplication(Program $program)
    {
        $volunteer = Auth::user()->volunteer;

        if (!$volunteer) {
            session()->flash('toast', ['message' => 'You need to submit a volunteer application first.', 'type' => 'error']);
            return redirect()->route('volunteer.application.form');
        }

        if ($program->volunteers->contains($volunteer->id)) {
            session()->flash('toast', ['message' => 'You are already enrolled in this program', 'type' => 'error']);
            return redirect()->back();
        }

        $program->volunteers()->attach($volunteer->id);

        session()->flash('toast', ['message' => 'You have successfully applied to the program', 'type' => 'success']);
        return redirect()->route('programs.index');
    }


    public function cancelApplication(Program $program)
    {
        $volunteer = Auth::user()->volunteer;

        if (!$volunteer) {
            return redirect()->route('volunteer.application.form')
                ->with('error', 'You need to submit a volunteer application first.');
        }

        $program->volunteers()->detach($volunteer->id);

        return redirect()->route('programs.index')->with('success', 'Your application to the program has been canceled.');
    }
}
