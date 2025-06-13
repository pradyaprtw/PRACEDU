<?php

namespace App\Http\Middleware;

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Jika user tidak memiliki role yang diizinkan
        if (! $request->user() || ! in_array($request->user()->role, $roles)) {
            // Redirect ke halaman login atau halaman lain yang sesuai
            abort(403, 'UNAUTHORIZED ACTION.');
        }

        return $next($request);
    }
}