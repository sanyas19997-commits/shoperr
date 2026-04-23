<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        // We don't register a named `login` route (the SPA handles it via
        // Vue Router), so fall back to the hard-coded path. Using `route('login')`
        // would throw RouteNotFoundException on non-AJAX access to protected
        // endpoints (e.g. direct browser hit on /api/orders).
        return $request->expectsJson() ? null : '/login';
    }
}
