<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Volunteer;

class VolunteerController extends Controller
{
    public function gotoVolunteersList()
    {
        $applications = Volunteer::with('user')
            ->where('application_status', 'pending')
            ->get();
            
        $deniedApplications = Volunteer::with('user')
            ->where('application_status', 'denied')
            ->get();
            
        $approvedVolunteers = Volunteer::with('user')
            ->where('application_status', 'approved')
            ->get();
            
        return view('volunteers.index', compact('applications', 'deniedApplications', 'approvedVolunteers'));
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    public function gotoVolunteerDetails($id)
    {
        //  volunteer with associated programs
        $volunteer = Volunteer::with('programs')->findOrFail($id);

        return view('volunteers.viewUser_details', compact('volunteer'));
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════
}
