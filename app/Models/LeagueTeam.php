<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;

class LeagueTeam extends Pivot
{
    protected $fillable = [
        'won',
        'drawn',
        'lost',
        'goals_for',
        'goals_against',
    ];

    //

    public function scopeOfLeague(Builder $query, $league_id)
    {
        $query->where('league_id', $league_id);
    }

    public function scopeOfTeam(Builder $query, $team_id)
    {
        $query->where('team_id', $team_id);
    }

    //

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    public function team(): BelongsTo
    {
        return $this->belongsTo(Team::class);
    }

    //

    public function played()
    {
        return $this->won + $this->drawn + $this->lost;
    }

    public function goal_difference()
    {
        return $this->goals_for - $this->goals_against;
    }

    public function points()
    {
        return ($this->won*3) + ($this->drawn*1);
    }
}
