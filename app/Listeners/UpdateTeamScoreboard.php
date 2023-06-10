<?php

namespace App\Listeners;

use App\Events\MatchPlayed;
use App\Models\LeagueTeam;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateTeamScoreboard
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(MatchPlayed $event)
    {
        $fixture = $event->fixture;

        if ($fixture->result_draw()) {
            $leagueTeam = LeagueTeam::query()->where('league_id', $fixture->league_id)->where('team_id', $fixture->home_team_id)->firstOrFail();
            $leagueTeam->update([
                'drawn' => $leagueTeam->drawn+1,
                'goals_for' => $leagueTeam->goals_for+$fixture->home_team_score,
                'goals_against' => $leagueTeam->goals_against+$fixture->away_team_score,
            ]);

            $leagueTeam = LeagueTeam::query()->where('league_id', $fixture->league_id)->where('team_id', $fixture->away_team_id)->firstOrFail();
            $leagueTeam->update([
                'drawn' => $leagueTeam->drawn+1,
                'goals_for' => $leagueTeam->goals_for+$fixture->away_team_score,
                'goals_against' => $leagueTeam->goals_against+$fixture->home_team_score,
            ]);
        } elseif ($fixture->result_home_team_winner()) {
            $leagueTeam = LeagueTeam::query()->where('league_id', $fixture->league_id)->where('team_id', $fixture->home_team_id)->firstOrFail();
            $leagueTeam->update([
                'won' => $leagueTeam->won+1,
                'goals_for' => $leagueTeam->goals_for+$fixture->home_team_score,
                'goals_against' => $leagueTeam->goals_against+$fixture->away_team_score,
            ]);

            $leagueTeam = LeagueTeam::query()->where('league_id', $fixture->league_id)->where('team_id', $fixture->away_team_id)->firstOrFail();
            $leagueTeam->update([
                'lost' => $leagueTeam->lost+1,
                'goals_for' => $leagueTeam->goals_for+$fixture->away_team_score,
                'goals_against' => $leagueTeam->goals_against+$fixture->home_team_score,
            ]);
        } else {
            $leagueTeam = LeagueTeam::query()->where('league_id', $fixture->league_id)->where('team_id', $fixture->home_team_id)->firstOrFail();
            $leagueTeam->update([
                'lost' => $leagueTeam->lost+1,
                'goals_for' => $leagueTeam->goals_for+$fixture->home_team_score,
                'goals_against' => $leagueTeam->goals_against+$fixture->away_team_score,
            ]);

            $leagueTeam = LeagueTeam::query()->where('league_id', $fixture->league_id)->where('team_id', $fixture->away_team_id)->firstOrFail();
            $leagueTeam->update([
                'won' => $leagueTeam->won+1,
                'goals_for' => $leagueTeam->goals_for+$fixture->away_team_score,
                'goals_against' => $leagueTeam->goals_against+$fixture->home_team_score,
            ]);
        }
    }
}
