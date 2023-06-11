<?php

namespace App\Services;

use App\Models\League;

class ScoreboardService
{
    protected League $league;
    protected $scoreboard;

    public function __construct(League $league)
    {
        $this->league = $league;
    }

    public function scoreboard()
    {
        $this->scoreboard = $this->league->teams()->get()->sortByDesc(function ($team) {
            return $team->pivot->points();
        })->values();
    }

    public function championshipPredictions()
    {
        $remainingWeeks = 6 - $this->league->at_week;
        $maxPoint = $this->scoreboard[0]->pivot->points();

        $unsuccessfulTeams = [];
        $totalPoints = 0;
        $rateToBeShared = 0;

        foreach ($this->scoreboard as $key => $team) {
            if ($team->pivot->points() + ($remainingWeeks*3) < $maxPoint) {
                $unsuccessfulTeams[] = $key;
            }

            $totalPoints += $team->pivot->points();
        }

        foreach ($this->scoreboard as $key => $team) {
            if (in_array($key, $unsuccessfulTeams)) {
                $rateToBeShared += (($team->pivot->points()/$totalPoints)*100);
            } else {
                $this->scoreboard[$key]->prediction = (($team->pivot->points()/$totalPoints)*100);
            }
        }

        foreach ($this->scoreboard as $key => $team) {
            if (!in_array($key, $unsuccessfulTeams)) {
                $prediction = $this->scoreboard[$key]->prediction;
                $prediction += ($rateToBeShared/(4-count($unsuccessfulTeams)));
                $this->scoreboard[$key]->prediction = number_format($prediction, 1);
            }
        }
    }

    public function returnScoreboard()
    {
        return $this->scoreboard;
    }
}
