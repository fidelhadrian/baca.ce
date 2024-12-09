<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = Auth::user();

        // Check if the user has the required role or a higher role
        if ($user && $this->hasRoleOrHigher($user->role->name, $role)) {
            return $next($request);
        }

        abort(403, 'Unauthorized');
    }

    /**
     * Determine if the user role is equal to or higher than the required role.
     */
    private function hasRoleOrHigher(string $userRole, string $requiredRole): bool
    {
        $roleHierarchy = [
            'superadmin' => 1,
            'admin' => 2,
            'student' => 3,
        ];

        return $roleHierarchy[$userRole] <= $roleHierarchy[$requiredRole];
    }
}