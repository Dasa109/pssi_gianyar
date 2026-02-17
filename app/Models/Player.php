<?php

namespace App\Models;

// HAPUS atau KOMENTARI baris ini:
// use Illuminate\Database\Eloquent\Model;

// TAMBAHKAN baris ini:
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// Ubah 'extends Model' menjadi 'extends Authenticatable'
class Player extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'password',
        'position',
        'number',
        'club_id',
        'club_dummy',
        'photo',
        'is_captain',
        'status',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_captain' => 'boolean',
        'password' => 'hashed',
    ];

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }
    
    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}