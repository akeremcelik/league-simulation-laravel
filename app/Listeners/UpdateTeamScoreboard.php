<?php

namespace App\Listeners;

use App\Actions\UpdateLeagueTeam;
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

        $leagueHomeTeam = LeagueTeam::query()->where('league_id', $fixture->league_id)->where('team_id', $fixture->home_team_id)->firstOrFail();
        $leagueAwayTeam = LeagueTeam::query()->where('league_id', $fixture->league_id)->where('team_id', $fixture->away_team_id)->firstOrFail();

        $leagueHomeTeamData = [
            'goals_for' => $leagueHomeTeam->goals_for+$fixture->home_team_score,
            'goals_against' => $leagueHomeTeam->goals_against+$fixture->away_team_score,
        ];
        $leagueAwayTeamData = [
            'goals_for' => $leagueAwayTeam->goals_for+$fixture->away_team_score,
            'goals_against' => $leagueAwayTeam->goals_against+$fixture->home_team_score,
        ];

        if ($fixture->result_draw()) {
            $leagueHomeTeamData['drawn'] = $leagueHomeTeam->drawn+1;
            $leagueAwayTeamData['drawn'] = $leagueAwayTeam->drawn+1;
        } elseif ($fixture->result_home_team_winner()) {
            $leagueHomeTeamData['won'] = $leagueHomeTeam->won+1;
            $leagueAwayTeamData['lost'] = $leagueAwayTeam->lost+1;
        } else {
            $leagueHomeTeamData['lost'] = $leagueHomeTeam->lost+1;
            $leagueAwayTeamData['won'] = $leagueAwayTeam->won+1;
        }

        (new UpdateLeagueTeam($leagueHomeTeam))->handle($leagueHomeTeamData);
        (new UpdateLeagueTeam($leagueAwayTeam))->handle($leagueAwayTeamData);
    }
}
