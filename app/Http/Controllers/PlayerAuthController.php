<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Player;

class PlayerAuthController extends Controller
{
    // =========================================================================
    // BAGIAN 1: OTENTIKASI (LOGIN & LOGOUT)
    // =========================================================================

    /**
     * Menampilkan Form Login
     */
    public function showLoginForm()
    {
        return view('player.login');
    }

    /**
     * Proses Login
     */
    public function login(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Coba Login menggunakan Guard 'player'
        if (Auth::guard('player')->attempt($credentials)) {
            $request->session()->regenerate();
            
            // Redirect ke dashboard jika sukses
            return redirect()->intended(route('player.dashboard'));
        }

        // 3. Jika Gagal, kembalikan ke halaman login dengan error
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    /**
     * Proses Logout
     */
    public function logout(Request $request)
    {
        Auth::guard('player')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('player.login');
    }


    // =========================================================================
    // BAGIAN 2: HALAMAN UTAMA (DASHBOARD)
    // =========================================================================

    /**
     * Menampilkan Dashboard Pemain
     */
    public function dashboard()
    {
        $player = Auth::guard('player')->user(); 
        return view('player.dashboard', compact('player'));
    }


    // =========================================================================
    // BAGIAN 3: PENGATURAN PROFIL (EDIT & UPDATE)
    // =========================================================================

    /**
     * Menampilkan Form Edit Profil
     */
    public function editProfile()
    {
        $player = Auth::guard('player')->user();
        return view('player.edit', compact('player'));
    }

    /**
     * Proses Simpan Perubahan Profil (Foto & Password)
     */
    public function updateProfile(Request $request)
    {
        $player = Auth::guard('player')->user();

        // 1. Validasi Input
        $request->validate([
            'photo' => 'nullable|image|max:2048', // Maksimal 2MB, harus gambar
            'password' => 'nullable|min:6|confirmed', // Min 6 huruf, harus sama dengan password_confirmation
        ]);

        // 2. Logika Update Foto
        if ($request->hasFile('photo')) {
            // A. Hapus foto lama jika ada (agar server tidak penuh)
            if ($player->photo && Storage::disk('public')->exists($player->photo)) {
                Storage::disk('public')->delete($player->photo);
            }
            
            // B. Simpan foto baru ke folder 'players' di storage public
            $path = $request->file('photo')->store('players', 'public');
            
            // C. Update path di database
            $player->photo = $path;
        }

        // 3. Logika Ganti Password (Hanya jika kolom diisi)
        if ($request->filled('password')) {
            $player->password = Hash::make($request->password);
        }

        // 4. Simpan ke Database
        $player->save();

        // 5. Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Profil Anda berhasil diperbarui!');
    }
}