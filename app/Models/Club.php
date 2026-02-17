<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    // 1. Sesuaikan Fillable dengan Database Migration terbaru
    protected $fillable = [
    'name', 
    'slug', 
    'nickname', 
    'logo', 
    'stadium', // Pastikan bukan stadium_name
    'address', 
    'phone', 
    'history', // Pastikan bukan description
    'founded'
];

    // 2. Wajib ada agar URL /klub/{slug} bisa jalan (Route Model Binding)
    public function getRouteKeyName()
    {
        return 'slug';
    }

    // --- RELASI ---

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    // Relasi ke Pertandingan (Match)
    // Kita gunakan string full class 'App\Models\Match' 
    // karena 'Match' adalah reserved keyword di PHP 8
    public function homeMatches()
    {
        return $this->hasMany('App\Models\Match', 'home_team_id');
    }

    public function awayMatches()
    {
        return $this->hasMany('App\Models\Match', 'away_team_id');
    }
}