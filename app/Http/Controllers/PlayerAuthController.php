<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\Player;
use App\Models\Club;

class PlayerAuthController extends Controller
{
    // =========================================================================
    // BAGIAN 1: REGISTRASI (PENDAFTARAN)
    // =========================================================================

    public function showRegisterForm()
    {
        // Ambil data klub untuk dropdown, urutkan A-Z (Hanya yang Approved)
        $clubs = Club::where('status', 'approved')->orderBy('name', 'asc')->get();
        return view('player.auth.register', compact('clubs'));
    }

    public function register(Request $request)
    {
        // 1. Validasi Input (PERBAIKAN: Sesuaikan dengan form yang ada)
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:players',
            'password' => 'required|string|min:6|confirmed',
            'club_id' => 'required|exists:clubs,id', // Wajib pilih klub
        ]);

        // 2. Simpan Data Pemain (Status default: pending)
        $player = Player::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'club_id' => $request->club_id, 
            'status' => 'pending', // Wajib pending agar dicek Admin Klub dulu
            // Position bisa diisi nanti saat pemain sudah bisa login ke dashboard
        ]);

        // 3. Redirect ke Login dengan Pesan Sukses
        return redirect()->route('player.login')
            ->with('success', 'Registrasi berhasil! Silakan tunggu persetujuan dari Manajer Klub sebelum login.');
    }

    // =========================================================================
    // BAGIAN 2: OTENTIKASI (LOGIN & LOGOUT)
    // =========================================================================

    public function showLoginForm()
    {
        return view('player.auth.login');
    }

    public function login(Request $request)
    {
        // 1. Validasi Input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // 2. Cek Status Akun Sebelum Login
        $player = Player::where('email', $request->email)->first();
        
        if ($player && $player->status === 'pending') {
             return back()->withErrors([
                'email' => 'Akun Anda sedang menunggu persetujuan Manajer Klub.',
            ])->onlyInput('email');
        }

        if ($player && $player->status === 'rejected') {
             return back()->withErrors([
                'email' => 'Maaf, pendaftaran akun Anda ditolak oleh Klub.',
            ])->onlyInput('email');
        }

        // 3. Coba Login (Gunakan guard 'player')
        if (Auth::guard('player')->attempt($credentials)) {
            $request->session()->regenerate();
            
            return redirect()->intended(route('player.dashboard'))
                             ->with('success', 'Login berhasil!');
        }

        // 4. Jika Password Salah
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

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

    public function dashboard()
    {
        $player = Auth::guard('player')->user(); 
        return view('player.dashboard', compact('player'));
    }

    // =========================================================================
    // BAGIAN 4: PENGATURAN PROFIL (EDIT & UPDATE)
    // =========================================================================

    public function editProfile()
    {
        $player = Auth::guard('player')->user();
        return view('player.edit', compact('player'));
    }

    public function updateProfile(Request $request)
    {
        $player = Auth::guard('player')->user();

        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|string', // Boleh null
            'photo' => 'nullable|image|max:2048', 
            'password' => 'nullable|min:6|confirmed',
        ]);

        // 2. Update Data Dasar
        $player->name = $request->name;
        
        if ($request->filled('position')) {
            $player->position = $request->position;
        }

        // 3. Logika Update Foto
        if ($request->hasFile('photo')) {
            if ($player->photo && Storage::disk('public')->exists($player->photo)) {
                Storage::disk('public')->delete($player->photo);
            }
            
            $path = $request->file('photo')->store('players/photos', 'public');
            $player->photo = $path;
        }

        // 4. Update Password (Hanya jika field diisi)
        if ($request->filled('password')) {
            $player->password = Hash::make($request->password);
        }

        // 5. Simpan ke Database
        $player->save();

        return back()->with('success', 'Profil Anda berhasil diperbarui!');
    }
}