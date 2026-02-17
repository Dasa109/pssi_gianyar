<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    // 1. Sesuaikan Fillable dengan Database
    protected $fillable = [
        'name', 
        'slug', 
        'short_name', // <-- PERBAIKAN: Tambahkan ini agar singkatan bisa disimpan
        'nickname', 
        'logo', 
        'stadium', 
        'address', 
        'phone', 
        'history', 
        'founded'
    ];

    // 2. Route Model Binding (agar URL /klub/ps-gianyar bisa jalan)
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // --- RELASI ---

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    public function homeMatches()
    {
        return $this->hasMany('App\Models\Match', 'home_team_id');
    }

    public function awayMatches()
    {
        return $this->hasMany('App\Models\Match', 'away_team_id');
    }
}