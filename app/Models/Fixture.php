<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Fixture extends Model
{
    use HasFactory;

    protected $fillable = [
        'week',
        'played',
        'home_team_score',
        'away_team_score',
    ];

    protected $casts = [
        'played' => 'boolean',
    ];

    public function scopeOfLeague(Builder $query, $league_id)
    {
        $query->where('league_id', $league_id);
    }

    public function scopeOfWeek(Builder $query, $week)
    {
        $query->where('week', $week);
    }

    public function scopeWeekAscending(Builder $query)
    {
        $query->orderBy('week', 'ASC');
    }

    public function scopePlayedStatus(Builder $query, $status)
    {
        $query->where('played', $status);
    }

    //

    public function league(): BelongsTo
    {
        return $this->belongsTo(League::class);
    }

    public function home_team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'home_team_id');
    }

    public function away_team(): BelongsTo
    {
        return $this->belongsTo(Team::class, 'away_team_id');
    }

    //

    public function result_draw()
    {
        return $this->home_team_score === $this->away_team_score;
    }

    public function result_home_team_winner()
    {
        return $this->home_team_score > $this->away_team_score;
    }

    public function result_away_team_winner()
    {
        return $this->home_team_score < $this->away_team_score;
    }
}
