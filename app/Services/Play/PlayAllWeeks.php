<?php

namespace App\Services\Play;

use App\Events\MatchPlayed;
use App\Events\WeekPlayed;
use App\Models\Fixture;
use App\Models\League;
use App\Services\PlayService;

class PlayAllWeeks extends PlayService
{
    protected League $league;

    public function __construct(League $league)
    {
        $this->league = $league;
    }

    public function findFixtures()
    {
        return Fixture::query()->ofLeague($this->league->id)->ofWeek($this->league->at_week+1)->playedStatus(false)->get();
    }

    public function play()
    {
        while ($this->league->fresh()->at_week < 6) {
            foreach ($this->findFixtures() as $fixture) {
                $this->playMatch($fixture);
                MatchPlayed::dispatch($fixture);
            }

            WeekPlayed::dispatch($this->league);
        }
    }
}
