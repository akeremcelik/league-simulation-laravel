<?php

namespace App\Actions;

use App\Models\Fixture;
use App\Models\League;
use App\Models\Team;

class StoreFixture
{
    protected League $league;
    protected int $week;
    protected Team $homeTeam;
    protected Team $awayTeam;

    public function __construct($league, $week, $homeTeam, $awayTeam)
    {
        $this->league = $league;
        $this->week = $week;
        $this->homeTeam = $homeTeam;
        $this->awayTeam = $awayTeam;
    }

    public function handle(): Fixture
    {
        $data = [
            'week' => $this->week,
        ];

        $fixture = new Fixture($data);

        $fixture->league()->associate($this->league);
        $fixture->home_team()->associate($this->homeTeam);
        $fixture->away_team()->associate($this->awayTeam);

        $fixture->save();

        return $fixture;
    }
}
