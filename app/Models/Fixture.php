<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fixture extends Model
{
    protected $guarded = [];

    public function homeTeam(): BelongsTo
    {
        // Diubah menjadi Customers::class sesuai nama model di folder Models kamu
        return $this->belongsTo(Customers::class, 'home_team_id');
    }

    public function awayTeam(): BelongsTo
    {
        // Diubah menjadi Customers::class
        return $this->belongsTo(Customers::class, 'away_team_id');
    }
}