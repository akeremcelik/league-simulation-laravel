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

    public function scopeWeekAscending(Builder $query)
    {
        $query->orderBy('week', 'ASC');
    }

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
}
