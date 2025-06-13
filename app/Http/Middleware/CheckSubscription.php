<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Subscription;

class CheckSubscription
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Admin selalu dapat akses
        if ($user->role === 'admin') {
            return $next($request);
        }

        // Cek langganan aktif
        $isActive = Subscription::where('user_id', $user->id)
                                ->where('end_date', '>=', now())
                                ->exists();

        if (!$isActive) {
            return redirect()->route('siswa.packages.index')->with('error', 'Anda harus memiliki paket langganan aktif untuk mengakses halaman ini.');
        }
        
        return $next($request);
    }
}
