<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    public function index()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();
        return view('roles.index', compact('users', 'roles'));
    }

    public function showAssignForm(Request $request)
    {
        $users = User::all();
        $roles = Role::all();
        
        // If a user is selected, get their current roles
        if ($request->has('user_id')) {
            $selectedUser = User::with('roles')->find($request->user_id);
            return view('roles.assign', compact('users', 'roles', 'selectedUser'));
        }
        
        return view('roles.assign', compact('users', 'roles'));
    }

    public function assign(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'roles' => 'nullable|array',
            'roles.*' => 'exists:roles,id'
        ]);

        try {
            DB::beginTransaction();

            $user = User::findOrFail($request->user_id);
            
            // Get current roles
            $currentRoles = $user->roles->pluck('id')->toArray();
            
            // Get the volunteer role
            $volunteerRole = Role::where('role_name', 'Volunteer')->first();
            
            // If no roles were selected in the form, use current roles
            $selectedRoles = $request->roles ?? $currentRoles;
            
            // Always ensure volunteer role is included if user has it
            if ($user->hasRole('Volunteer') && !in_array($volunteerRole->id, $selectedRoles)) {
                $selectedRoles[] = $volunteerRole->id;
            }

            // Only proceed with sync if there are actual changes
            if (count(array_diff($selectedRoles, $currentRoles)) > 0 || 
                count(array_diff($currentRoles, $selectedRoles)) > 0) {
                
                // Create sync data with pivot information
                $syncData = collect($selectedRoles)->mapWithKeys(function ($roleId) {
                    return [$roleId => [
                        'assigned_by' => Auth::id(),
                        'assigned_at' => now()
                    ]];
                })->all();
                
                $user->roles()->sync($syncData);
            }

            DB::commit();

            return redirect()->back()->with('toast', [
                'message' => 'Roles updated successfully',
                'type' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('toast', [
                'message' => 'Failed to update roles. Please try again.',
                'type' => 'error'
            ]);
        }
    }
} 