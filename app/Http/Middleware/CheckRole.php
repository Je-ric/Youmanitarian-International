<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
class CheckRole
{
    public function handle(Request $request, Closure $next, $roles)
    {
        $user = Auth::user();
        $rolesArray = explode(',', $roles); // Convert comma-separated roles into an array

        // Check if the user has any of the specified roles
        foreach ($rolesArray as $role) {
            $role = trim($role); // Remove extra spaces

            if ($user->hasRole($role)) {
                return $next($request); // If the user has the role, allow access
            }
        }

        // If no role matches, redirect or show unauthorized message
        return redirect('/'); // Or any other route or error message
    }
}
