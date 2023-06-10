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
    public function generateFixtures(FixtureService $fixtureService)
    {
        $league = (new StoreLeague())->handle();
        $teams = Team::all()->take(4);

        $generatedFixtures = $fixtureService->generateFixtures($teams);
        foreach ($generatedFixtures as $generatedFixture) {
            $storeFixture = new StoreFixture($league, $generatedFixture['week'], $teams[$generatedFixture['home_team_index']], $teams[$generatedFixture['away_team_index']]);
            $storeFixture->handle();
        }

        $fixtures = Fixture::query()->where('league_id', $league->id)->orderBy('week', 'ASC')->get();
        return FixtureResource::collection($fixtures);
    }
}
