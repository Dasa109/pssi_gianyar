<?php

use App\Http\Controllers\ClubController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');

});

Route::get('/klub', [ClubController::class, 'index'])->name('clubs.index');
Route::get('/klub/{slug}', [ClubController::class, 'show'])->name('clubs.show');


