<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

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

    // --- RELASI ---

    public function players()
    {
        return $this->hasMany(Player::class);
    }

    // PERBAIKAN DI SINI:
    // Gunakan string 'App\Models\Match' agar tidak bentrok dengan keyword PHP
    
    public function homeMatches()
    {
        return $this->hasMany('App\Models\Match', 'home_team_id');
    }

    public function awayMatches()
    {
        return $this->hasMany('App\Models\Match', 'away_team_id');
    }
}