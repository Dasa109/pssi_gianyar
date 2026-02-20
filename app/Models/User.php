<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Activitylog\Traits\LogsActivity; // <-- Import LogsActivity
use Spatie\Activitylog\LogOptions;        // <-- Import LogOptions

class User extends Authenticatable implements FilamentUser
{
    // <-- Tambahkan LogsActivity di sini
    use HasApiTokens, HasFactory, Notifiable, LogsActivity; 

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',    
        'club_id', 
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // --- FITUR LOG AKTIVITAS (AUDIT TRAIL) ---
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Data User ini telah di-{$eventName}");
    }

    // --- 1. HELPER CEK ROLE ---
    public function isSuperAdmin(): bool
    {
        return $this->role === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

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
        return true; 
    }
}