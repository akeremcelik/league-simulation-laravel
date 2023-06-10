<?php

namespace App\Http\Controllers\Api\V1;

use App\Actions\StoreFixture;
use App\Actions\StoreLeague;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\FixtureResource;
use App\Models\Fixture;
use App\Models\Team;
use App\Services\FixtureService;
use Illuminate\Http\Request;

class FixtureController extends Controller
{
    public function generateFixtures()
    {
        $league = (new StoreLeague())->handle();
        $teams = Team::all()->take(4);

        $fixtureService = new FixtureService($teams);
        $generatedFixtures = $fixtureService->generateFixtures();

        foreach ($generatedFixtures as $generatedFixture) {
            $storeFixture = new StoreFixture([
                'league' => $league,
                'week' => $generatedFixture['week'],
                'home_team' => $teams[$generatedFixture['home_team_index']],
                'away_team' => $teams[$generatedFixture['away_team_index']],
            ]);
            $storeFixture->handle();
        }

        $fixtures = Fixture::query()->ofLeague($league->id)->weekAscending()->get();

        return FixtureResource::collection($fixtures);
    }
}
