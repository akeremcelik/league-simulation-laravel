<?php

namespace App\Services;

use App\Actions\UpdateFixture;
use App\Models\Fixture;
use App\Models\League;
use App\Models\Team;

abstract class PlayService
{
    const MAX_GOAL = 8;
    const DRAW_FACTOR = 0.2;
    const HOME_FACTOR = 0.1;

    public abstract function play();

    public function findFixtures(League $league)
    {
        return Fixture::query()->ofLeague($league->id)->ofWeek($league->at_week+1)->playedStatus(false)->get();
    }

    public function playMatch(Fixture $fixture)
    {
        $matchResult = $this->determineMatchResult($fixture->home_team, $fixture->away_team);

        $updateFixture = new UpdateFixture($fixture);
        $updateFixture->handle([
            'played' => true,
            'home_team_score' => $matchResult['home_team_score'],
            'away_team_score' => $matchResult['away_team_score'],
        ]);
    }

    public function determineMatchResult(Team $homeTeam, Team $awayTeam)
    {
        $result = [];

        $homeTeam->strength += ($homeTeam->strength)*self::HOME_FACTOR;
        $totalStrength = $homeTeam->strength + $awayTeam->strength + (($homeTeam->strength + $awayTeam->strength)*self::DRAW_FACTOR);
        $randomInt = random_int(0, $totalStrength);

        if ($randomInt <= $homeTeam->strength) {
            $result['home_team_score'] = random_int(1, self::MAX_GOAL);
            $result['away_team_score'] = random_int(0, $result['home_team_score']-1);
        } elseif ($randomInt > $homeTeam->strength && $randomInt < $awayTeam->strength) {
            $drawScore = random_int(0, self::MAX_GOAL);
            $result = [
                'home_team_score' => $drawScore,
                'away_team_score' => $drawScore,
            ];
        } else {
            $result['away_team_score'] = random_int(1, self::MAX_GOAL);
            $result['home_team_score'] = random_int(0, $result['away_team_score']-1);
        }

        return $result;
    }
}
