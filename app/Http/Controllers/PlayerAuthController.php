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
    // BAGIAN 1: REGISTRASI (PENDAFTARAN)
    // =========================================================================

    /**
     * Menampilkan Form Registrasi
     */
    public function showRegisterForm()
    {
        return view('player.auth.register');
    }

    /**
     * Proses Registrasi Pemain Baru
     */
    public function register(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:players',
            'password' => 'required|string|min:6|confirmed',
            'position' => 'required|string',
            'club_dummy' => 'nullable|string|max:255',
        ]);

        // 2. Simpan Data Pemain
        $player = Player::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Hash password manual
            'position' => $request->position,
            'club_dummy' => $request->club_dummy ?? 'Free Agent',
        ]);

        // 3. Auto Login
        Auth::guard('player')->login($player);

        // 4. Redirect ke Dashboard
        return redirect()->route('player.dashboard')
                         ->with('success', 'Registrasi berhasil! Selamat datang.');
    }

    // =========================================================================
    // BAGIAN 2: OTENTIKASI (LOGIN & LOGOUT)
    // =========================================================================

    /**
     * Menampilkan Form Login
     */
    public function showLoginForm()
    {
        return view('player.auth.login'); // Pastikan nama file view sesuai
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

        // 2. Coba Login (Ingat: Gunakan guard 'player')
        if (Auth::guard('player')->attempt($credentials)) {
            $request->session()->regenerate();
            
            return redirect()->intended(route('player.dashboard'))
                             ->with('success', 'Login berhasil!');
        }

        // 3. Jika Gagal
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

        return redirect()->route('player.login')
                         ->with('success', 'Anda telah logout.');
    }


    // =========================================================================
    // BAGIAN 3: HALAMAN UTAMA (DASHBOARD)
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
    // BAGIAN 4: PENGATURAN PROFIL (EDIT & UPDATE)
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
     * Proses Simpan Perubahan Profil
     */
    public function updateProfile(Request $request)
    {
        $player = Auth::guard('player')->user();

        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'required|string',
            'club_dummy' => 'nullable|string|max:255',
            'photo' => 'nullable|image|max:2048', // Max 2MB
            'password' => 'nullable|min:6|confirmed', // Opsional
        ]);

        // 2. Update Data Teks (Nama, Posisi, Klub)
        // Kita gunakan forceFill atau update manual
        $player->name = $request->name;
        $player->position = $request->position;
        $player->club_dummy = $request->club_dummy;

        // 3. Logika Update Foto
        if ($request->hasFile('photo')) {
            // Hapus foto lama jika bukan default/kosong
            if ($player->photo && Storage::disk('public')->exists($player->photo)) {
                Storage::disk('public')->delete($player->photo);
            }
            
            // Simpan foto baru
            $path = $request->file('photo')->store('players', 'public');
            $player->photo = $path;
        }

        // 4. Logika Ganti Password (Hanya jika diisi)
        if ($request->filled('password')) {
            $player->password = Hash::make($request->password);
        }

        // 5. Simpan Perubahan
        $player->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}