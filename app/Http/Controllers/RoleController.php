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
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id'
        ]);

        try {
            DB::beginTransaction();

            $user = User::findOrFail($request->user_id);
            
            // Sync roles (this will remove roles not in the array and add new ones)
            $user->roles()->sync($request->roles, [
                'assigned_by' => Auth::id(),
                'assigned_at' => now()
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Roles updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to update roles. Please try again.']);
        }
    }
} 