<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
    'name',
    'email',
    'password',
    'role', // <--- Pastikan ini sudah ditambahkan
];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // --- LOGIKA MULTI-USER ---

    // 1. Relasi: User ini megang klub apa?
    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    // 2. Cek apakah dia Super Admin (PSSI)
    public function isSuperAdmin()
{
    return $this->role === 'super_admin';
}
    public function isAdmin()
{
    return $this->role === 'admin';
}

    // 3. Cek apakah dia Operator Klub
    public function isClubOperator(): bool
    {
        return $this->role === 'operator' && $this->club_id !== null;
    }

    // 4. Izin Login ke Filament
    public function canAccessPanel(Panel $panel): bool
    {
        // Semua user (admin & operator) boleh login
        // Jika nanti mau dibatasi, ubah logic di sini
        return true; 
    }
}