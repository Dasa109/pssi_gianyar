<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Player extends Authenticatable
{
    use HasFactory, Notifiable;

    // 1. Definisikan Guard (Penting agar Auth::guard('player') berjalan mulus)
    protected $guard = 'player';

    // 2. Update Fillable: Tambahkan 'club_dummy' untuk input manual
    protected $fillable = [
        'name', 
        'email', 
        'password',
        'position', 
        'club_dummy', // <--- Field baru untuk nama klub sementara (teks)
        
        // Field lama (biarkan saja, nanti bisa dipakai admin)
        'club_id', 
        'number', 
        'photo', 
        'is_captain',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        // 'password' => 'hashed',  <-- Tetap dimatikan (karena kita hash manual di Controller)
        'is_captain' => 'boolean',
    ];

    // Relasi ke Club (Opsional: akan null jika club_id kosong)
    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}