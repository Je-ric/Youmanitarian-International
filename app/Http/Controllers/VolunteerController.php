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
    // volunteers/index.blade.php (main)
    public function gotoVolunteersList()
    {
        $applications = Volunteer::with('user')
            ->where('application_status', 'pending')
            ->paginate(10);

        $deniedApplications = Volunteer::with('user')
            ->where('application_status', 'denied')
            ->paginate(10);

        $approvedVolunteers = Volunteer::with('user')
            ->where('application_status', 'approved')
            ->paginate(10);

        $total = $approvedVolunteers->count() + $deniedApplications->count();
        $approvalRate = $total > 0 ? round(($approvedVolunteers->count() / $total) * 100) : 0;

        $recentActivities = $applications->merge($deniedApplications)->merge($approvedVolunteers)
            ->sortByDesc('updated_at')
            ->take(5);

        return view('volunteers.index',
        compact(
            'applications',
            'deniedApplications',
            'approvedVolunteers',
            'approvalRate',
            'recentActivities'
        ));
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    // volunteers/volunteer-details.blade.php (main)
    public function gotoVolunteerDetails($id)
    {
        //  volunteer with associated programs
        $volunteer = Volunteer::with('programs')->findOrFail($id);

        return view('volunteers.volunteer-details', compact('volunteer'));
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════
}
