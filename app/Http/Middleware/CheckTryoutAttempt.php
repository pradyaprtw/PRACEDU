<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class CheckTryoutAttempt
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $packageId = $request->route('packageId');
        $user = Auth::user();

        $existingAttempt = \App\Models\TryoutPackageAttempt::where('user_id', $user->id)
            ->where('package_id', $packageId)
            ->first();

        if ($existingAttempt) {
            return redirect()->route('siswa.tryout.packageResult', $packageId)->with('error', 'Kamu sudah mengerjakan tryout ini.');
        }

        return $next($request);
    }
}
