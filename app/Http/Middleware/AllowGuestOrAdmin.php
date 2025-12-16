<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AllowGuestOrAdmin
{
    public function handle($request, Closure $next)
    {
        if (!Auth::check()) {
            return $next($request); // guest
        }

        if (Auth::user()->role === 'admin') {
            return $next($request); // admin
        }

        abort(403);
    }
}
