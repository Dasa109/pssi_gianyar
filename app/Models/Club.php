<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    // Kita izinkan semua kolom ini untuk diisi data
    protected $fillable = [
        'name',
        'slug',
        'short_name',
        'logo',
        'stadium_name',
        'address',
        'phone',
        'history',
    ];
}