<?php

namespace App\Actions;

use App\Models\Fixture;

class StoreFixture
{
    public function handle(array $data): Fixture
    {
        $storeData = [
            'week' => $data['week'],
        ];

        $fixture = new Fixture($storeData);

        $fixture->league()->associate($data['league']);
        $fixture->home_team()->associate($data['home_team']);
        $fixture->away_team()->associate($data['away_team']);

        $fixture->save();

        return $fixture;
    }
}
