<?php

namespace App\Http\Controllers;

use App\Models\Volunteer;
use Illuminate\Http\Request;

class VolunteerApprovalController extends Controller
{
    /*
     * Approved a volunteer application
     */
    public function approve($id)
    {
        $volunteer = Volunteer::findOrFail($id);

        $volunteer->application_status = 'approved';
        $volunteer->joined_at = now();
        $volunteer->save();

        return redirect()->back()->with('toast', [
            'message' => 'Volunteer application approved successfully.',
            'type' => 'success'
        ]);
    }

    /*
     * Deny a volunteer application
     */
    public function deny($id)
    {
        $volunteer = Volunteer::findOrFail($id);

        $volunteer->application_status = 'denied';
        $volunteer->save();

        return redirect()->back()->with('toast', [
            'message' => 'Volunteer application denied.',
            'type' => 'warning'
        ]);
    }

    /**
     * Restore a denied volunteer application back to pending
     */
    public function restore($id)
    {
        $volunteer = Volunteer::findOrFail($id);

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
