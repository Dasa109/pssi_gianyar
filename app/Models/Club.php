<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity; // Import Trait Log
use Spatie\Activitylog\LogOptions;        // Import Opsi Log

class Club extends Model
{
    use HasFactory, LogsActivity; // Aktifkan pencatatan aktivitas

    protected $fillable = [
        'name', 
        'slug', 
        'short_name', 
        'nickname', 
        'logo', 
        'stadium', 
        'address', 
        'phone', 
        'history', 
        'founded'
    ];

    /**
     * Konfigurasi Log: Mencatat siapa yang mengubah data klub
     * Berguna untuk jejak audit forensik digital.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable() // Otomatis catat semua kolom yang ada di $fillable
            ->logOnlyDirty() // Hanya catat jika ada perubahan data (efisiensi storage)
            ->dontSubmitEmptyLogs();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // --- RELASI ---

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    /**
     * Menggunakan string class agar lebih aman jika model Match belum di-import
     */
    public function homeMatches()
    {
        return $this->hasMany('App\Models\Match', 'home_team_id');
    }

    public function awayMatches()
    {
        return $this->hasMany('App\Models\Match', 'away_team_id');
    }

    /**
     * Relasi ke User (Operator Klub)
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
