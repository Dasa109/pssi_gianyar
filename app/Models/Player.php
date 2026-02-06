<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = [
        'club_id',
        'name',
        'number',
        'position',
        'photo',      // <--- WAJIB ADA! Kalau ini hilang, foto tidak akan tersimpan.
        'is_captain',
    ];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }
}