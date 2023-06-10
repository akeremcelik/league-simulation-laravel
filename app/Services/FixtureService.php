<?php

namespace App\Services;

class FixtureService
{
    protected $teams;

    public function __construct($teams)
    {
        $this->teams = $teams;
    }

    public function generateFixtures()
    {
        $fixtures = [];
        $teamMatches = $this->matchTeams();

        foreach ($teamMatches as $key => $teamMatch) {
            $week = ($key%3)+1;
            $firstTeamIsHome = random_int(0, 1);

            $fixtures[] = [
                'week' => $week,
                'home_team_index' => $teamMatch[$firstTeamIsHome],
                'away_team_index' => $teamMatch[!$firstTeamIsHome],
            ];

            $fixtures[] = [
                'week' => $week+3,
                'home_team_index' => $teamMatch[!$firstTeamIsHome],
                'away_team_index' => $teamMatch[$firstTeamIsHome],
            ];
        }

        return $fixtures;
    }

    public function matchTeams()
    {
        $teamMatches = [];

        foreach ($this->teams as $key_1 => $team_1) {
            foreach ($this->teams as $key_2 => $team_2) {
                if ($key_1 < $key_2) {
                    $teamMatches[] = [$key_1, $key_2];
                }
            }
        }

        return $teamMatches;
    }
}
