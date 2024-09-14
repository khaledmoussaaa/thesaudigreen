<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, String $role): Response
    {
        $user = Auth::user();

        // Check if the user is authenticated
        if (!$user) {
            return abort(401, 'Unauthorized');
        }

        // Allow admin to access any route
        if ($user->usertype == 'Admin' && $role != 'Customer') {
            return $next($request);
        }

        // Check if the user's role matches the required role
        if ($user->usertype == $role) {
            return $next($request);
        }

        // If none of the conditions are met, deny access
        return abort(403, 'Forbidden');
    }
}
