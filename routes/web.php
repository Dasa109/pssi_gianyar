<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClubController;       
use App\Http\Controllers\PlayerAuthController; 
use App\Models\User;
// PERBAIKAN: Gunakan controller web, bukan API
use App\Http\Controllers\ClubRegistrationController; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- 1. HALAMAN PUBLIK ---
Route::get('/', function () {
    return view('welcome');
});

// Route Klub (Publik)
Route::get('/klub', [ClubController::class, 'index'])->name('clubs.index');
Route::get('/klub/{slug}', [ClubController::class, 'show'])->name('clubs.show');

// Route Pendaftaran Klub (Web Blade)
Route::get('/mendaftar', [ClubRegistrationController::class, 'create'])->name('club.register');
Route::post('/mendaftar', [ClubRegistrationController::class, 'store'])->name('club.store');

// --- 2. PORTAL PEMAIN (AUTH SYSTEM) ---
Route::prefix('portal-pemain')->name('player.')->group(function () {
    
    // Redirect otomatis ke login
    Route::redirect('/', '/portal-pemain/login');

    // A. TAMU (Belum Login)
    Route::middleware('guest:player')->group(function () {
        Route::get('login', [PlayerAuthController::class, 'showLoginForm'])->name('login');
        Route::post('login', [PlayerAuthController::class, 'login'])->name('login.submit');
        
        Route::get('register', [PlayerAuthController::class, 'showRegisterForm'])->name('register');
        Route::post('register', [PlayerAuthController::class, 'register'])->name('register.store');
    });

    // B. MEMBER (Sudah Login)
    Route::middleware('auth:player')->group(function () {
        Route::get('dashboard', [PlayerAuthController::class, 'dashboard'])->name('dashboard');
        Route::post('logout', [PlayerAuthController::class, 'logout'])->name('logout');
        
        Route::get('profil/edit', [PlayerAuthController::class, 'editProfile'])->name('edit');
        Route::put('profil/update', [PlayerAuthController::class, 'updateProfile'])->name('update');
    });

});