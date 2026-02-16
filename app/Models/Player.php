<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Player extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'club_id', 'name', 'email', 'password',
        'number', 'position', 'photo', 'is_captain',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        // 'password' => 'hashed',  <-- INI SAYA HAPUS (Biang Kerok Double Hash)
        'is_captain' => 'boolean', // Opsional: Biar is_captain terbaca true/false (bukan 1/0)
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}