<?php

namespace App\Actions;

use App\Models\Fixture;

class UpdateFixture
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function handle(): ?Fixture
    {
        $data = [
            'played' => $this->data['played'],
            'home_team_score' => $this->data['home_team_score'],
            'away_team_score' => $this->data['away_team_score'],
        ];

        $fixture = $this->data['fixture'];
        $fixture->update($data);

        return $fixture->fresh();
    }
}
