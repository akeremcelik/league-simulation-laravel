<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ScoreboardResource;
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

        return ScoreboardResource::collection($scoreboardService->returnScoreboard());
    }

    public function playAllWeeks(Request $request, League $league)
    {
        (new PlayAllWeeks($league))->play();
        $scoreboardService = new ScoreboardService($league);

        $scoreboardService->scoreboard();

        return ScoreboardResource::collection($scoreboardService->returnScoreboard());
    }
}
