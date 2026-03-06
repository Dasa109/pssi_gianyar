<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    /**
     * Menggunakan guarded kosong agar semua kolom, termasuk 'logo' yang baru ditambahkan,
     * bisa disimpan ke database tanpa error MassAssignmentException.
     */
    protected $guarded = [];

    /**
     * Relasi ke Fixtures (Opsional, tapi bagus untuk dimiliki)
     * Satu tim (Customer) bisa memiliki banyak jadwal pertandingan.
     */
    public function fixtures()
    {
        return $this->hasMany(Fixture::class, 'home_team_id');
    }
}