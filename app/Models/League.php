<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class League extends Model
{
    use HasFactory;

    protected $fillable = [
        'at_week',
    ];

    public function teams(): BelongsToMany
    {
        return $this->belongsToMany(Team::class)
            ->using(LeagueTeam::class)
            ->withPivot('won', 'drawn', 'lost', 'goals_for', 'goals_against');
    }
}
