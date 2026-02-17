<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClubController;       
use App\Http\Controllers\PlayerAuthController; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- 1. HALAMAN PUBLIK ---
Route::get('/', function () {
    return view('welcome');
});

// Route Klub
Route::get('/klub', [ClubController::class, 'index'])->name('clubs.index');

// ✅ FIX: Baris ini sudah saya aktifkan (uncomment) agar detail klub bisa dibuka
Route::get('/klub/{slug}', [ClubController::class, 'show'])->name('clubs.show');


// --- 2. PORTAL PEMAIN (AUTH SYSTEM) ---
Route::prefix('portal-pemain')->name('player.')->group(function () {
    
    // Redirect: Jika user akses '/portal-pemain', lempar ke halaman login
    Route::redirect('/', '/portal-pemain/login');

    // A. TAMU (Belum Login)
    Route::middleware('guest:player')->group(function () {
        // Login
        Route::get('login', [PlayerAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [PlayerAuthController::class, 'login'])->name('login.submit');

        // Registrasi
        Route::get('register', [PlayerAuthController::class, 'showRegisterForm'])->name('register');
        Route::post('register', [PlayerAuthController::class, 'register'])->name('register.store');
    });

    // B. MEMBER (Sudah Login)
    Route::middleware('auth:player')->group(function () {
        // Dashboard Utama
        Route::get('dashboard', [PlayerAuthController::class, 'dashboard'])->name('dashboard');
        
        // Logout
        Route::post('logout', [PlayerAuthController::class, 'logout'])->name('logout');

        // Edit Profil
        Route::get('profil/edit', [PlayerAuthController::class, 'editProfile'])->name('edit');
        Route::put('profil/update', [PlayerAuthController::class, 'updateProfile'])->name('update');
    });

});