<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return response()->json(['message' => 'Не авторизован.'], 401);
        }

        $allowed = false;
        foreach ($roles as $role) {
            if ($role === 'staff' && $user->isStaff()) {
                $allowed = true;
                break;
            }
            if ($user->hasRole($role) || ($role === 'admin' && $user->isAdmin())) {
                $allowed = true;
                break;
            }
        }

        if (! $allowed) {
            return response()->json(['message' => 'Недостаточно прав.'], 403);
        }

        return $next($request);
    }
}
