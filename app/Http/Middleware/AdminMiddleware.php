<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        // Not logged in → redirect to login page
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to access the admin panel.');
        }

        // Logged in but not admin → 403
        if (auth()->user()->role !== 'admin') {
            abort(403, 'Unauthorized Access');
        }

        return $next($request);
    }
}