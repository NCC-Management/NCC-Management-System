<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();

                // Redirect admins to admin dashboard, others to normal dashboard
                if ($user && ((isset($user->role) && $user->role === 'admin') || !empty($user->is_admin))) {
                    return redirect()->route('admin.dashboard');
                }

                return redirect()->route('dashboard');
            }
        }

        return $next($request);
    }
}