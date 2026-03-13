<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CadetApprovedMiddleware
{
    /**
     * Block cadets that haven't been approved yet.
     * Redirect them to dashboard where the pending/rejected message is shown.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if (!$user || $user->role !== 'cadet') {
            abort(403);
        }

        $cadet = $user->cadet;

        if (!$cadet || $cadet->status !== 'approved') {
            return redirect()->route('cadet.dashboard')
                ->with('info', 'You need admin approval to access this page.');
        }

        return $next($request);
    }
}
