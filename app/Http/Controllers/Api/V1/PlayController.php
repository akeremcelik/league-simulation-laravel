<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ScoreboardResource;
use App\Models\Fixture;
use App\Models\League;
use App\Services\Play\PlayAllWeeks;
use App\Services\Play\PlayNextWeek;
use App\Services\ScoreboardService;
use Illuminate\Http\Request;

class PlayController extends Controller
{
    public function playNextWeek(Request $request, League $league)
    {
        (new PlayNextWeek($league))->play();

        $scoreboardService = new ScoreboardService($league);
        $scoreboardService->scoreboard();

        if ($league->fresh()->at_week >= 3) {
            $scoreboardService->championshipPredictions();
        }

        $previousWeekFixtures = Fixture::query()->ofLeague($league->id)->ofWeek($league->at_week)->get()->toArray();

        return ScoreboardResource::collection($scoreboardService->returnScoreboard())
            ->additional([
                'previous_week_fixtures' => $previousWeekFixtures,
            ]);
    }

    public function playAllWeeks(Request $request, League $league)
    {
        (new PlayAllWeeks($league))->play();

        $scoreboardService = new ScoreboardService($league);
        $scoreboardService->scoreboard();

        $previousWeekFixtures = Fixture::query()->ofLeague($league->id)->ofWeek($league->fresh()->at_week)->get()->toArray();

        return ScoreboardResource::collection($scoreboardService->returnScoreboard())
            ->additional([
                'previous_week_fixtures' => $previousWeekFixtures,
            ]);
    }
}
