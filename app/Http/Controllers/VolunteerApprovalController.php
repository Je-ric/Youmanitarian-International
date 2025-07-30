<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use Illuminate\Http\Request;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\VolunteerApplicationStatusUpdated;

class VolunteerApprovalController extends Controller
{
    // application.blade.php
    public function approve($id)
    {
        // get the volunteer id, since meron na nung nag-apply
        // optional kung gagawin (transfer application status sa volunteer_application table)
        $volunteer = Volunteer::findOrFail($id);
        $user = $volunteer->user;

        // get the volunteer role
        $volunteerRole = Role::where('role_name', 'Volunteer')->first();

        if (!$volunteerRole) {
            return redirect()->back()->with('toast', [
                'message' => 'Volunteer role not found in the system.',
                'type' => 'error'
            ]);
        }

        // ito lang yung may try-catch because it involves multiple database operations na dapat mag-succeed lahat.
        try {
            DB::beginTransaction();

            $volunteer->application_status = 'approved';
            $volunteer->joined_at = now();
            $volunteer->save();

            // Assign the volunteer role if not already assigned
            if (!$user->hasRole('Volunteer')) {
                DB::table('user_roles')->insert([  // Create the role assignment in user_roles table
                    'user_id' => $user->id,
                    'role_id' => $volunteerRole->id,
                    'assigned_by' => Auth::id(),
                    'assigned_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }

            DB::commit();

            // Send notification sa approved volunteer  \Notifications\VolunteerApplicationStatusUpdated.php
            $user->notify(new VolunteerApplicationStatusUpdated('approved'));

            return redirect()->back()->with('toast', [
                'message' => 'Volunteer application approved successfully.',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('toast', [
                'message' => 'Failed to approve volunteer application. Please try again.',
                'type' => 'error'
            ]);
        }
    }

    // application.blade.php
    public function deny($id)
    {
        $volunteer = Volunteer::findOrFail($id);

        $volunteer->application_status = 'denied';
        $volunteer->save();

        // Send notification sa denied volunteer  \Notifications\VolunteerApplicationStatusUpdated.php
        $volunteer->user->notify(new VolunteerApplicationStatusUpdated('denied'));

        return redirect()->back()->with('toast', [
            'message' => 'Volunteer application denied.',
            'type' => 'warning'
        ]);
    }

    // application.blade.php
    public function restore($id)
    {
        $volunteer = Volunteer::findOrFail($id);

        // make sure na yung status is denied bago ma-restore again to pending
        if ($volunteer->application_status !== 'denied') {
            return redirect()->back()->with('toast', [
                'message' => 'Only denied applications can be restored.',
                'type' => 'error'
            ]);
        }

        $volunteer->application_status = 'pending';
        $volunteer->save();

        return redirect()->back()->with('toast', [
            'message' => 'Volunteer application restored to pending status.',
            'type' => 'success'
        ]);
    }
}
