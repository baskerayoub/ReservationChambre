<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     * Usage: middleware('role:admin,receptionist')
     */
    public function handle(Request $request, Closure $next, string ...$roles): mixed
    {
        if (! $request->user() || ! in_array($request->user()->role, $roles)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}
