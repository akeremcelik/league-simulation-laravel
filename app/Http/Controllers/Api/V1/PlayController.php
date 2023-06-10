<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\MatchPlayed;
use App\Http\Controllers\Controller;
use App\Models\Fixture;
use App\Models\League;
use App\Services\PlayService;
use Illuminate\Http\Request;

class PlayController extends Controller
{
    public function playNextWeek(Request $request, League $league, PlayService $playService)
    {
        $nextWeek = $league->at_week+1;
        $fixtures = Fixture::query()->ofLeague($league->id)->ofWeek($nextWeek)->playedStatus(false)->get();

        foreach ($fixtures as $fixture) {
            $playService->playMatch($fixture);
        }

        MatchPlayed::dispatch($league);
    }

    public function playAllWeeks(Request $request, League $league, PlayService $playService)
    {
        $fixtures = Fixture::query()->ofLeague($league->id)->playedStatus(false)->get();

        foreach ($fixtures as $fixture) {
            $playService->playMatch($fixture);
        }
    }
}
