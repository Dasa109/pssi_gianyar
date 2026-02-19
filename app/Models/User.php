<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Tambahan untuk relasi
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
        'role',    // <--- Penting untuk Super Admin / Admin
        'club_id', // <--- Penting jika User adalah Operator Klub
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

    // --- 1. HELPER CEK ROLE ---

    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    // Cek apakah dia Operator Klub (Punya role operator & terhubung ke data klub)
    public function isClubOperator(): bool
    {
        return $this->role === 'operator' && $this->club_id !== null;
    }

    // --- 2. RELASI DATABASE ---

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }

    // --- 3. KONFIGURASI FILAMENT ---

    public function canAccessPanel(Panel $panel): bool
    {
        // Izinkan login jika user punya status Super Admin atau Admin
        // Anda bisa memperketat logika ini jika perlu
        return true; 
    }
}