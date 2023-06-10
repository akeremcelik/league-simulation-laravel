<?php

namespace App\Actions;

use App\Models\Fixture;

class UpdateFixture
{
    public Fixture $fixture;
    public array $data;

    public function __construct(Fixture $fixture, array $data)
    {
        $this->fixture = $fixture;
        $this->data = $data;
    }

    public function handle(): ?Fixture
    {
        $data = [
            'played' => $this->data['played'],
            'home_team_score' => $this->data['home_team_score'],
            'away_team_score' => $this->data['away_team_score'],
        ];

        $this->fixture->update($data);
        return $this->fixture->fresh();
    }
}
