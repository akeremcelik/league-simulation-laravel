<?php

namespace App\Actions;

use App\Models\Fixture;

class UpdateFixture
{
    protected Fixture $fixture;
    protected bool $played;
    protected int $home_team_score;
    protected int $away_team_score;

    public function __construct($fixture, $played, $home_team_score, $away_team_score)
    {
        $this->fixture = $fixture;
        $this->played = $played;
        $this->home_team_score = $home_team_score;
        $this->away_team_score = $away_team_score;
    }

    public function handle(): ?Fixture
    {
        $data = [
            'played' => $this->played,
            'home_team_score' => $this->home_team_score,
            'away_team_score' => $this->away_team_score,
        ];

        $this->fixture->update($data);

        return $this->fixture->fresh();
    }
}
