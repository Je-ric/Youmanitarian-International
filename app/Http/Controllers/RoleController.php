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
        $allUsers = User::with('roles')->get();
        $roles = Role::all();

        // Get users for each role
        $volunteerUsers = $allUsers->filter(fn($user) => $user->hasRole('Volunteer'));
        $adminUsers = $allUsers->filter(fn($user) => $user->hasRole('Admin'));
        $programCoordinatorUsers = $allUsers->filter(fn($user) => $user->hasRole('Program Coordinator'));
        $financialCoordinatorUsers = $allUsers->filter(fn($user) => $user->hasRole('Financial Coordinator'));
        $contentManagerUsers = $allUsers->filter(fn($user) => $user->hasRole('Content Manager'));
        $memberUsers = $allUsers->filter(fn($user) => $user->hasRole('Member'));

        // Paginate each role's users
        $perPage = 10;
        
        $volunteerCurrentPage = request()->get('volunteer_page', 1);
        $adminCurrentPage = request()->get('admin_page', 1);
        $programCoordinatorCurrentPage = request()->get('program_coordinator_page', 1);
        $financialCoordinatorCurrentPage = request()->get('financial_coordinator_page', 1);
        $contentManagerCurrentPage = request()->get('content_manager_page', 1);
        $memberCurrentPage = request()->get('member_page', 1);
        $noRoleCurrentPage = request()->get('no_role_page', 1);
        
        $volunteerUsersPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $volunteerUsers->forPage($volunteerCurrentPage, $perPage),
            $volunteerUsers->count(),
            $perPage,
            $volunteerCurrentPage,
            ['path' => request()->url(), 'query' => request()->query(), 'pageName' => 'volunteer_page']
        );

        $adminUsersPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $adminUsers->forPage($adminCurrentPage, $perPage),
            $adminUsers->count(),
            $perPage,
            $adminCurrentPage,
            ['path' => request()->url(), 'query' => request()->query(), 'pageName' => 'admin_page']
        );

        $programCoordinatorUsersPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $programCoordinatorUsers->forPage($programCoordinatorCurrentPage, $perPage),
            $programCoordinatorUsers->count(),
            $perPage,
            $programCoordinatorCurrentPage,
            ['path' => request()->url(), 'query' => request()->query(), 'pageName' => 'program_coordinator_page']
        );

        $financialCoordinatorUsersPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $financialCoordinatorUsers->forPage($financialCoordinatorCurrentPage, $perPage),
            $financialCoordinatorUsers->count(),
            $perPage,
            $financialCoordinatorCurrentPage,
            ['path' => request()->url(), 'query' => request()->query(), 'pageName' => 'financial_coordinator_page']
        );

        $contentManagerUsersPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $contentManagerUsers->forPage($contentManagerCurrentPage, $perPage),
            $contentManagerUsers->count(),
            $perPage,
            $contentManagerCurrentPage,
            ['path' => request()->url(), 'query' => request()->query(), 'pageName' => 'content_manager_page']
        );

        $memberUsersPaginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $memberUsers->forPage($memberCurrentPage, $perPage),
            $memberUsers->count(),
            $perPage,
            $memberCurrentPage,
            ['path' => request()->url(), 'query' => request()->query(), 'pageName' => 'member_page']
        );

        $activeUsers = $allUsers->filter(fn($user) => $user->is_active);

        $usersWithoutRolesCollection = $allUsers->filter(fn($user) => $user->roles->isEmpty());
        $usersWithoutRoles = new \Illuminate\Pagination\LengthAwarePaginator(
            $usersWithoutRolesCollection->forPage($noRoleCurrentPage, $perPage),
            $usersWithoutRolesCollection->count(),
            $perPage,
            $noRoleCurrentPage,
            ['path' => request()->url(), 'query' => request()->query(), 'pageName' => 'no_role_page']
        );

        return view('roles.index', compact(
            'allUsers',
            'roles',
            'activeUsers',
            'usersWithoutRoles',
            'volunteerUsers',
            'adminUsers',
            'programCoordinatorUsers',
            'financialCoordinatorUsers',
            'contentManagerUsers',
            'memberUsers',
            'volunteerUsersPaginated',
            'adminUsersPaginated',
            'programCoordinatorUsersPaginated',
            'financialCoordinatorUsersPaginated',
            'contentManagerUsersPaginated',
            'memberUsersPaginated'
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