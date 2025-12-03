<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        // Pastikan user login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Pastikan role sama
        if (strtolower(Auth::user()->role) !== strtolower($role)) {
            abort(403, 'Akses tidak dibenarkan.');
        }

        return $next($request);
    }
}
