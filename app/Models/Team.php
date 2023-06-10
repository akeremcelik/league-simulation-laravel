<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'strength',
    ];

    public function leagues(): BelongsToMany
    {
        return $this->belongsToMany(League::class)
            ->using(LeagueTeam::class)
            ->withPivot('won', 'drawn', 'lost', 'goals_for', 'goals_against');
    }
}
