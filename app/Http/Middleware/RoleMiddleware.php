<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Ambil user yang sedang login
        $user = Auth::guard('web')->user();

        // Cek apakah user login
        if (!$user) {
            abort(403, 'Unauthorized - User not logged in');
        }

        // Cek apakah user memiliki role yang sesuai
        if (!$user->roles()->where('name', $role)->exists()) {
            abort(403, 'Unauthorized - Role mismatch');
        }

        return $next($request);
    }
}
