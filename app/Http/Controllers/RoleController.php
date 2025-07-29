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
        $allUsers = User::with('roles')->get(); // function to get all users with their roles
        $roles = Role::all(); // get all roles

        // Get users for each role
        // filter() to return only users with the role, inshort kinukuha lang yung users na may specific role
        // since meron tayong function na $allUsers, tinatanggal nito yung user na wala namang role (depende sa hinahanap)
        $volunteerUsers = $allUsers->filter(fn($user) => $user->hasRole('Volunteer'));
        $adminUsers = $allUsers->filter(fn($user) => $user->hasRole('Admin'));
        $programCoordinatorUsers = $allUsers->filter(fn($user) => $user->hasRole('Program Coordinator'));
        $financialCoordinatorUsers = $allUsers->filter(fn($user) => $user->hasRole('Financial Coordinator'));
        $contentManagerUsers = $allUsers->filter(fn($user) => $user->hasRole('Content Manager'));
        $memberUsers = $allUsers->filter(fn($user) => $user->hasRole('Member'));

        $perPage = 10;

        // request()->get() to get the current page number from the URL
        // if no page number is provided, default to 1
        // if page number is provided, use that page number (paginate)

        // Example:
        // default: http://127.0.0.1:8000/roles/list?tab=volunteer (admin, program_coordinator, financial_coordinator, content_manager, no_roles)
        // http://127.0.0.1:8000/roles/list?tab=Volunteer&volunteer_page=2
        $volunteerCurrentPage = request()->get('volunteer_page', 1);
        $adminCurrentPage = request()->get('admin_page', 1);
        $programCoordinatorCurrentPage = request()->get('program_coordinator_page', 1);
        $financialCoordinatorCurrentPage = request()->get('financial_coordinator_page', 1);
        $contentManagerCurrentPage = request()->get('content_manager_page', 1);
        $memberCurrentPage = request()->get('member_page', 1);
        $noRoleCurrentPage = request()->get('no_role_page', 1);

        // Example:
        // Total volunteers: 50
        // Per page: 10 users
        // Current page: 1 (Default, show kung ano lang muna)
        // Current page: 2 (show the 11-20)
        // Current page: 3 (show the 21-30)
        // URL: http://127.0.0.1:8000/roles/list?tab=Volunteer&volunteer_page=2

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

        // get all users na walang roles
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
        $users = User::all(); // get all users
        $roles = Role::all(); // get all roles

        // if a user is selected, get their current roles (show the form)
        // request()->has() to check if the form was submitted with a user selected
        // it's checking for form data (modal), not URL parameters.
        if ($request->has('user_id')) {
            $selectedUser = User::with('roles')->find($request->user_id); // get user id with roles
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

        // try-catch to handle kung ano mang uri ng error and may rollback
        // may error logs din kung sakali
        // and try-catch can ba used mainly kung may function na mag-iinsert/update sa more than one table
        try {
            DB::beginTransaction(); // all changes will be saved or rolled back togerther, again try-catch mainly use because? READ ABOVE

            // findOrFail to get the user id and if not found, throw an error
            // $request->user_id to get the user id from the form data (kung may user_id sa form) sa modal
            $user = User::findOrFail($request->user_id);

            // get current roles ng selected user
            // $user->roles to get the roles of the user (from model)
            // pluck() to get the id/role_name of the roles
            // toArray() to convert the collection to an array
            $currentRoleIds = $user->roles->pluck('id')->toArray();
            $currentRoleNames = $user->roles->pluck('role_name')->toArray();

            // if no roles were selected in the form, treat it as an empty array.
            //
            $selectedRoleIds = $request->roles ?? [];

            // get the volunteer role
            $volunteerRole = Role::where('role_name', 'Volunteer')->first(); //

            // Always ensure volunteer role is included if user has it
            if ($user->hasRole('Volunteer') && !in_array($volunteerRole->id, $selectedRoleIds)) {
                $selectedRoleIds[] = $volunteerRole->id;
            }

            // determine what roles were added or removed
            $addedRoleIds = array_diff($selectedRoleIds, $currentRoleIds);
            $removedRoleIds = array_diff($currentRoleIds, $selectedRoleIds);

            // only proceed if there are actual changes
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
