<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\User; // <-- Wajib import model User
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB; // <-- Wajib import DB untuk Transaction

class ClubRegistrationController extends Controller
{
    public function create()
    {
        return view('register-club'); 
    }

    public function store(Request $request)
    {
        // 1. Validasi Input (Gabungan Data Klub & Data Akun Manajer)
        $validated = $request->validate([
            // --- Data Klub ---
            'name' => 'required|string|max:255|unique:clubs,name',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'legal_document' => 'required|file|mimes:pdf,zip|max:5120',
            
            // --- Data Akun Manajer ---
            'manager_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.unique' => 'Nama klub ini sudah terdaftar.',
            'email.unique' => 'Email ini sudah digunakan oleh manajer lain.',
            'legal_document.mimes' => 'Dokumen harus PDF atau ZIP.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
        ]);

        // 2. Gunakan Database Transaction untuk Keamanan Data
        DB::beginTransaction();

        try {
            // A. Upload file dokumen klub
            $documentPath = null;
            if ($request->hasFile('legal_document')) {
                $documentPath = $request->file('legal_document')->store('clubs/documents', 'public');
            }

            // B. Simpan data Klub (Otomatis berstatus 'pending')
            $club = Club::create([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
                'phone' => $validated['phone'],
                'address' => $validated['address'],
                'legal_document' => $documentPath,
                'status' => 'pending', 
            ]);

            // C. Simpan data Manajer sebagai User Filament (Role: operator)
            // Dan langsung hubungkan dengan club_id yang baru saja dibuat
            User::create([
                'name' => $validated['manager_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'operator',
                'club_id' => $club->id, 
            ]);

            // D. Jika semua sukses, commit/permanenkan data ke database
            DB::commit();

            return redirect()->back()->with('success', 'Pendaftaran Klub & Akun Manajer berhasil dikirim! Silakan tunggu persetujuan dari Admin PSSI Gianyar.');

        } catch (\Exception $e) {
            // E. Jika ada error di tengah jalan, batalkan semua perubahan
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Terjadi kesalahan sistem saat menyimpan data. Silakan coba lagi.'])->withInput();
        }
    }
}