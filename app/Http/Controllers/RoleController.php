<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Notifications\UserRolesUpdated;

class RoleController extends Controller
{
    public function gotoRolesList()
    {
        $users = User::with('roles')->get();
        $roles = Role::all();

        // Required for Overview
        $activeUsers = $users->filter(fn($user) => $user->is_active);
        $usersWithoutRoles = $users->filter(fn($user) => $user->roles->isEmpty());

        return view('roles.index', compact(
            'users',
            'roles',
            'activeUsers',
            'usersWithoutRoles'
        ));
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
            $currentRoleIds = $user->roles->pluck('id')->toArray();
            $currentRoleNames = $user->roles->pluck('role_name')->toArray();

            // If no roles were selected in the form, treat it as an empty array.
            $selectedRoleIds = $request->roles ?? [];
            
            // Get the volunteer role
            $volunteerRole = Role::where('role_name', 'Volunteer')->first();
            
            // Always ensure volunteer role is included if user has it
            if ($user->hasRole('Volunteer') && !in_array($volunteerRole->id, $selectedRoleIds)) {
                $selectedRoleIds[] = $volunteerRole->id;
            }

            // Determine what roles were added or removed
            $addedRoleIds = array_diff($selectedRoleIds, $currentRoleIds);
            $removedRoleIds = array_diff($currentRoleIds, $selectedRoleIds);

            // Only proceed if there are actual changes
            if (!empty($addedRoleIds) || !empty($removedRoleIds)) {
                
                // Create sync data with pivot information
                $syncData = collect($selectedRoleIds)->mapWithKeys(function ($roleId) {
                    return [$roleId => [
                        'assigned_by' => Auth::id(),
                        'assigned_at' => now()
                    ]];
                })->all();
                
                $user->roles()->sync($syncData);

                // Get role names for notification
                $addedRoleNames = Role::whereIn('id', $addedRoleIds)->pluck('role_name')->all();
                $removedRoleNames = Role::whereIn('id', $removedRoleIds)->pluck('role_name')->all();

                $user->notify(new UserRolesUpdated($addedRoleNames, $removedRoleNames));
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