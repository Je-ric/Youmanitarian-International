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

    public function apply()
    {
        $user = Auth::user();
        $pendingRequest = Volunteer::where('user_id', $user->id)->exists();

        if ($pendingRequest) {
            session()->flash('toast', [
                'message' => 'Your volunteer application is already pending or approved.',
                'type' => 'info'
            ]);
            return redirect()->back();
        }

        Volunteer::create([
            'user_id' => $user->id,
            'total_hours' => 0,
            'status' => 'pending',
        ]);

        session()->flash('toast', ['message' => 'Your application has been submitted for approval.', 'type' => 'success']);
        return redirect()->back();
    }


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

        return view('volunteers.details', compact('volunteer'));
    }
}
