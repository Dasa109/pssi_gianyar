<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GameResult extends Model
{
    /**
     * Jurus "Paling Aman": Mengosongkan guarded.
     * Ini akan mengizinkan semua kolom (fixture_id, home_score, away_score) 
     * bisa disimpan tanpa error MassAssignmentException lagi.
     */
    protected $guarded = [];

    /**
     * Relasi ke model Fixture (Jadwal Pertandingan).
     * Pastikan model Fixture.php juga sudah benar relasinya.
     */
    public function fixture(): BelongsTo
    {
        return $this->belongsTo(Fixture::class);
    }
}