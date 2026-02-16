<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClubController;       // Pastikan file Controller ini ada
use App\Http\Controllers\PlayerAuthController; // Pastikan file Controller ini ada

// --- 1. Halaman Depan (Landing Page) ---
Route::get('/', function () {
    return view('welcome');
});

// --- 2. Halaman Publik Klub ---
// (Pastikan kamu sudah membuat ClubController, jika belum, comment dulu 2 baris ini agar tidak error)
Route::get('/klub', [ClubController::class, 'index'])->name('clubs.index');
Route::get('/klub/{slug}', [ClubController::class, 'show'])->name('clubs.show');


// --- 3. PORTAL PEMAIN (LOGIN & DASHBOARD) ---
Route::prefix('portal-pemain')->group(function () {
    
    // FIX PENTING: Jika akses /portal-pemain saja, lempar ke /portal-pemain/login
    Route::redirect('/', '/portal-pemain/login');
    
    // A. Halaman Login (Hanya untuk tamu/belum login)
    Route::middleware('guest:player')->group(function () {
        Route::get('login', [PlayerAuthController::class, 'showLoginForm'])->name('player.login');
        Route::post('login', [PlayerAuthController::class, 'login'])->name('player.login.submit');
    });

    // B. Halaman Dashboard (Hanya untuk pemain yang sudah login)
    Route::middleware('auth:player')->group(function () {
        Route::get('dashboard', [PlayerAuthController::class, 'dashboard'])->name('player.dashboard');
        Route::post('logout', [PlayerAuthController::class, 'logout'])->name('player.logout');

        // ... di dalam Route::middleware('auth:player')->group(function () { ...

    Route::get('dashboard', [PlayerAuthController::class, 'dashboard'])->name('player.dashboard');
    Route::post('logout', [PlayerAuthController::class, 'logout'])->name('player.logout');

    // --- TAMBAHKAN INI (FITUR EDIT PROFIL) ---
    Route::get('profil/edit', [PlayerAuthController::class, 'editProfile'])->name('player.edit');
    Route::put('profil/update', [PlayerAuthController::class, 'updateProfile'])->name('player.update');

// ... tutup group// ... di dalam Route::middleware('auth:player')->group(function () { ...

    Route::get('dashboard', [PlayerAuthController::class, 'dashboard'])->name('player.dashboard');
    Route::post('logout', [PlayerAuthController::class, 'logout'])->name('player.logout');

    // --- TAMBAHKAN INI (FITUR EDIT PROFIL) ---
    Route::get('profil/edit', [PlayerAuthController::class, 'editProfile'])->name('player.edit');
    Route::put('profil/update', [PlayerAuthController::class, 'updateProfile'])->name('player.update');

// ... tutup group
    });
});