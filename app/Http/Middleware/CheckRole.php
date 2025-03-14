<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Ensure the user is authenticated and has a matching role
        if (!auth()->check() || !in_array(auth()->user()->role, $roles)) {
            return redirect()->route('login')->with('error', 'Unauthorized access.'); // Custom redirect
    }

        return $next($request);
    }
}
