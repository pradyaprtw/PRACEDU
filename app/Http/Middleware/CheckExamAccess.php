<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckExamAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        $userExamAttempt = $request->route('userExamAttempt');

        if ($userExamAttempt->user_id !== Auth::id()) {
            abort(403, 'Anda tidak diizinkan mengakses halaman ini.');
        }

        return $next($request);
    }
}
