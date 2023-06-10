<?php

namespace App\Actions;

use App\Models\Fixture;

class StoreFixture
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function handle(): Fixture
    {
        $data = [
            'week' => $this->data['week'],
        ];

        $fixture = new Fixture($data);

        $fixture->league()->associate($this->data['league']);
        $fixture->home_team()->associate($this->data['home_team']);
        $fixture->away_team()->associate($this->data['away_team']);

        $fixture->save();

        return $fixture;
    }
}
