<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;

class ClubController extends Controller
{
    public function index()
    {
        // PERBAIKAN: Hanya ambil klub yang sudah di-Approve oleh Super Admin
        $clubs = Club::where('status', 'approved')
                    ->latest()
                    ->get();
                    
        return view('pages.clubs.index', compact('clubs'));
    }

    public function show($slug)
    {
        // PERBAIKAN: Pastikan klub tersebut 'approved', jika tidak maka tampilkan 404
        // Tambahan: Gunakan with('players') (Eager Loading) agar database tidak kerja keras 
        // saat kamu melooping data pemain di halaman detail klub nanti.
        $club = Club::where('slug', $slug)
                    ->where('status', 'approved')
                    ->with(['players' => function ($query) {
                        // Opsional: Tarik hanya pemain yang statusnya aktif
                        $query->where('status', 'active'); 
                    }])
                    ->firstOrFail();
                    
        return view('pages.clubs.show', compact('club'));
    }
}