<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, $roleName)
    {
        $hasRequiredRole = false;
        $requiredRoles = Role::pluck('name')->toArray();
        $user = auth()->id();

        // Get the user's roles
        $userRoles = UserRole::where('u_id', $user)->pluck('role_id');

        // Get the role names associated with the user's roles
        $roleNames = Role::whereIn('role_id', $userRoles)->pluck('name');

        // Check if the user has at least one of the required roles
        if ($roleNames->intersect($requiredRoles)->isNotEmpty()) {
            return $next($request);
        }

        // Set the session message
        $request->session()->put('session_msg', 'Your account does not have privilege for this action.');

        // Redirect to the home route
        return redirect()->route('dashboard');


    }
}
