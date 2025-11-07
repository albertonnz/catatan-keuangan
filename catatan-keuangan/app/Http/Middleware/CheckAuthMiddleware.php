<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckAuthMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Jika user belum login
        if (!Auth::check()) {
            return redirect('/auth/login');
        }

        // Jika user sudah login → lanjutkan request
        return $next($request);
    }
}
