<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Infraction extends Model
{
    /**
     * Jurus "Sakti" agar tidak kena MassAssignmentException lagi.
     * Dengan mengosongkan guarded, semua kolom form (fixture_id, customer_id, dll)
     * akan diizinkan masuk ke database.
     */
    protected $guarded = [];

    /**
     * Relasi ke Jadwal Pertandingan
     */
    public function fixture(): BelongsTo
    {
        return $this->belongsTo(Fixture::class);
    }

    /**
     * Relasi ke Pemain (Customers) yang melanggar
     */
    public function customer(): BelongsTo
    {
        // Sesuaikan dengan nama model tim/pemain kamu (Customers)
        return $this->belongsTo(Customers::class, 'customer_id');
    }
}