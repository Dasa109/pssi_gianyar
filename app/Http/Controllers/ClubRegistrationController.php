<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClubRegistrationController extends Controller
{
    /**
     * Menampilkan halaman form pendaftaran (Method create)
     */
    public function create()
    {
        return view('register-club'); 
    }

    /**
     * Memproses data yang dikirim dari form (Method store)
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'legal_document' => 'required|file|mimes:pdf,zip|max:5120',
        ], [
            'legal_document.mimes' => 'Dokumen harus berupa file PDF atau ZIP.',
            'legal_document.max' => 'Ukuran dokumen maksimal 5MB.',
        ]);

        // 2. Upload file
        $documentPath = null;
        if ($request->hasFile('legal_document')) {
            $documentPath = $request->file('legal_document')->store('clubs/documents', 'public');
        }

        // 3. Simpan ke database
        Club::create([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'legal_document' => $documentPath,
            'status' => 'pending', 
        ]);

        // 4. Kembali ke form dengan pesan sukses
        return redirect()->back()->with('success', 'Pendaftaran berhasil dikirim! Silakan tunggu persetujuan dari Admin PSSI Gianyar.');
    }
}