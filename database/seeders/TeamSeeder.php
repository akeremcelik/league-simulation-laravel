<?php

namespace Database\Seeders;

use App\Actions\StoreTeam;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $teams = [
            [
                'name' => 'Liverpool',
                'strength' => 70,
            ],
            [
                'name' => 'Manchester City',
                'strength' => 85,
            ],
            [
                'name' => 'Chelsea',
                'strength' => 60,
            ],
            [
                'name' => 'Arsenal',
                'strength' => 35,
            ],
        ];

        foreach ($teams as $team) {
            $storeTeam = new StoreTeam($team);
            $storeTeam->handle();
        }
    }
}
