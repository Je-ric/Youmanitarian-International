<?php
// Hindi nagagamit ngayon, along with volunteer.requests for in general volunteer management
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use App\Models\Volunteer;

class VolunteerController extends Controller
{

    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    public function allVolunteers()
    {
        $volunteers = Volunteer::with('user')->get();
        return view('volunteers.requests', compact('volunteers'));
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════


    public function showDetails($id)
    {
        //  volunteer with associated programs
        $volunteer = Volunteer::with('programs')->findOrFail($id);

        return view('volunteers.viewUser_details', compact('volunteer'));
    }

    // Standby   
    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════


}
