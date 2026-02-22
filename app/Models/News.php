<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity; // <-- Import Trait Log
use Spatie\Activitylog\LogOptions;        // <-- Import Opsi Log

class News extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'title', 
        'slug', 
        'category', 
        'content', 
        'thumbnail', 
        'status', 
        'is_emergency', 
        'published_at'
    ];

    // Beri tahu Laravel tipe data khusus
    protected $casts = [
        'is_emergency' => 'boolean',
        'published_at' => 'datetime',
    ];

    // Konfigurasi Log Aktivitas
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(fn(string $eventName) => "Artikel berita telah di-{$eventName}");
    }
    
    // Fungsi pembantu untuk memformat tanggal tayang
    public function getFormattedDateAttribute()
    {
        return $this->published_at ? $this->published_at->format('d M Y') : '-';
    }
}