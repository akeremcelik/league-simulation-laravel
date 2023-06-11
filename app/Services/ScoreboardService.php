<?php

namespace App\Services;

use App\Models\League;

class ScoreboardService
{
    protected League $league;

    public function __construct(League $league)
    {
        $this->league = $league;
    }

    public function scoreboard()
    {
        return $this->league->teams()->get()->sortByDesc(function ($team) {
            return $team->pivot->points();
        })->values();
    }
}
