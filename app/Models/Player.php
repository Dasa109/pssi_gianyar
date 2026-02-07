<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // <--- PENTING: Ganti Model jadi ini
use Illuminate\Notifications\Notifiable;

class Player extends Authenticatable // <--- Ubah ini
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'club_id', 'name', 'email', 'password', // Tambahkan email & password
        'number', 'position', 'photo', 'is_captain',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed', // Otomatis hash password saat disimpan
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}