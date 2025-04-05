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


    public function approve(User $user)
    {
        $volunteer = Volunteer::where('user_id', $user->id)->first();

        if (!$volunteer) {
            return redirect()->back()->with('error', 'Volunteer request not found.');
        }

        // Change status
        $volunteer->update(['status' => 'approved']);

        // Assign Volunteer role 
        $volunteerRole = Role::where('role_name', 'Volunteer')->first();
        if ($volunteerRole && !UserRole::where('user_id', $user->id)->where('role_id', $volunteerRole->id)->exists()) {
            UserRole::create([
                'user_id' => $user->id,
                'role_id' => $volunteerRole->id,
                'assigned_by' => Auth::id(),
            ]);
        }

        session()->flash('toast', ['message' => 'Volunteer approved successfully.', 'type' => 'success']);
        return redirect()->route('volunteers.requests');
    }


    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════


    public function remove(User $user)
    {
        $volunteer = Volunteer::where('user_id', $user->id)->first();

        if (!$volunteer) {
            return redirect()->back()->with('error', 'Volunteer request not found.');
        }

        // Change status
        $volunteer->update(['status' => 'denied']);

        // Remove volunteer role
        UserRole::where('user_id', $user->id)->delete();


        session()->flash('toast', ['message' => 'Volunteer removed successfully.', 'type' => 'error']);
        return redirect()->route('volunteers.requests');
    }


    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    
    public function restore(User $user)
    {
        $volunteer = Volunteer::where('user_id', $user->id)->first();

        if (!$volunteer) {
            session()->flash('toast', ['message' => 'Volunteer request not found.', 'type' => 'error']);
            return redirect()->back();
        }

        // Change status
        $volunteer->update(['status' => 'pending']);

        // Remove volunteer role
        $volunteerRole = Role::where('role_name', 'Volunteer')->first();
        if ($volunteerRole) {
            UserRole::where('user_id', $user->id)
                ->where('role_id', $volunteerRole->id)
                ->delete();
        }

        session()->flash('toast', ['message' => 'Volunteer status has been restored to pending.', 'type' => 'warning']);
        return redirect()->route('volunteers.requests');
    }
}
