<?php

namespace App\Services\Play;

use App\Events\MatchPlayed;
use App\Events\WeekPlayed;
use App\Models\League;
use App\Services\PlayService;

class PlayNextWeek extends PlayService
{
    protected League $league;

    public function __construct(League $league)
    {
        $this->league = $league;
    }

    public function play()
    {
        $fixtures = $this->findFixtures($this->league);
        if ($fixtures->count()) {
            foreach ($fixtures as $fixture) {
                $this->playMatch($fixture);
                MatchPlayed::dispatch($fixture);
            }

            WeekPlayed::dispatch($this->league);
        }
    }
}
