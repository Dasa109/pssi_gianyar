<?php

use App\Http\Controllers\ClubController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlayerAuthController;

Route::get('/', function () {
    return view('welcome');

});

Route::get('/klub', [ClubController::class, 'index'])->name('clubs.index');
Route::get('/klub/{slug}', [ClubController::class, 'show'])->name('clubs.show');


Route::prefix('portal-pemain')->group(function () {
    
    // Halaman Login (Hanya untuk tamu/belum login)
    Route::middleware('guest:player')->group(function () {
        Route::get('login', [PlayerAuthController::class, 'showLoginForm'])->name('player.login');
        Route::post('login', [PlayerAuthController::class, 'login']);
    });

    // Halaman Dashboard (Hanya untuk pemain yang sudah login)
    Route::middleware('auth:player')->group(function () {
        Route::get('dashboard', [PlayerAuthController::class, 'dashboard'])->name('player.dashboard');
        Route::post('logout', [PlayerAuthController::class, 'logout'])->name('player.logout');
    });
});