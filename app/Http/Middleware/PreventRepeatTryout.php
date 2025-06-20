<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class PreventRepeatTryout
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $packageId = $request->route('packageId');
        if (\App\Models\TryoutPackageAttempt::where('user_id', $user->id)->where('package_id', $packageId)->exists()) {
            return redirect()->route('siswa.tryout.packageResult', $packageId);
        }
        return $next($request);
    }
}
