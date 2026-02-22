<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $latestNews = News::where('status', 'published')->latest('published_at')->take(3)->get();
        $emergencyNews = News::where('status', 'published')->where('is_emergency', true)->latest('published_at')->first();

        return view('welcome', compact('latestNews', 'emergencyNews'));
    }

    // --- TAMBAHKAN FUNGSI INI ---
    public function showNews($slug)
    {
        // Cari berita berdasarkan slug. Jika tidak ada atau belum di-publish, tampilkan 404 Not Found.
        $news = News::where('slug', $slug)
                    ->where('status', 'published')
                    ->firstOrFail();

        return view('news.show', compact('news'));
    }
}