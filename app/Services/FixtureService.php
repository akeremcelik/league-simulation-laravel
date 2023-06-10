<?php

namespace App\Services;

class FixtureService
{
    public function generateFixtures($teams)
    {
        $fixtures = [];
        $teamMatches = $this->matchTeams($teams);

        foreach ($teamMatches as $key => $teamMatch) {
            $week = ($key%3)+1;
            $firstTeamIsHome = (bool) random_int(0, 1);

            $fixtures[] = [
                'week' => $week,
                'home_team_index' => $teamMatch[$firstTeamIsHome ? 0 : 1],
                'away_team_index' => $teamMatch[$firstTeamIsHome ? 1 : 0],
            ];

            $fixtures[] = [
                'week' => $week+3,
                'home_team_index' => $teamMatch[$firstTeamIsHome ? 1 : 0],
                'away_team_index' => $teamMatch[$firstTeamIsHome ? 0 : 1],
            ];
        }

        return $fixtures;
    }

    public function matchTeams($teams)
    {
        $teamMatches = [];

        foreach ($teams as $key_1 => $team_1) {
            foreach ($teams as $key_2 => $team_2) {
                if ($key_1 < $key_2) {
                    $teamMatches[] = [$key_1, $key_2];
                }
            }
        }

        return $teamMatches;
    }
}
