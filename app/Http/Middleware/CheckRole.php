<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
        public function handle($request, Closure $next, ...$roles)
    {
        // Get the authenticated user's ID
        $userId = Auth::id();

        // Get the user's role ID
        $userRoleId = UserRole::where('u_id', $userId)->value('role_id');

        // Get the role name associated with the user's role
        $userRole = Role::find($userRoleId);

        // Check if the user has any of the required roles
        foreach ($roles as $role) {
            if ($userRole->name === $role) {
                // User has the required role, allow access
                return $next($request);
            }
        }

        // Set the session message
        $request->session()->put('session_msg', 'Your account does not have privilege for this action.');

        // Redirect to the home route
        return redirect()->route('dashboard');
    }
}
