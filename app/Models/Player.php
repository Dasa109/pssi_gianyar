<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity; // <-- Import LogsActivity
use Spatie\Activitylog\LogOptions;        // <-- Import LogOptions

class Player extends Authenticatable
{
    // <-- Tambahkan LogsActivity di sini
    use HasFactory, LogsActivity; 

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

    // --- FITUR LOG AKTIVITAS (AUDIT TRAIL) ---
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Data Pemain telah di-{$eventName}");
    }

    public function club(): BelongsTo
    {
        return $this->belongsTo(Club::class);
    }
    
    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}