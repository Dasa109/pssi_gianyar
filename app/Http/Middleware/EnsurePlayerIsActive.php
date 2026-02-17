<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsurePlayerIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek jika user login DAN statusnya bukan active
        if (Auth::check() && Auth::user()->status !== 'active') {
            
            // Logout paksa
            Auth::logout();
            
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            // Kembalikan ke login dengan pesan error
            return redirect()->route('login')
                ->with('error', 'Akun Anda masih dalam status PENGAJUAN. Harap hubungi Manajer Klub untuk persetujuan.');
        }

        return $next($request);
    }
}