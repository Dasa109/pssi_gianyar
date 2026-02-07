<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PlayerAuthController extends Controller
{
    // 1. Tampilkan Form Login
    public function showLoginForm()
    {
        return view('player.login');
    }

    // 2. Proses Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba login menggunakan Guard 'player'
        if (Auth::guard('player')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/portal-pemain/dashboard');
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ]);
    }

    // 3. Proses Logout
    public function logout(Request $request)
    {
        Auth::guard('player')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/portal-pemain/login');
    }

    // 4. Halaman Dashboard
    public function dashboard()
    {
        // Ambil data pemain yang sedang login
        $player = Auth::guard('player')->user(); 
        
        return view('player.dashboard', compact('player'));
    }
}