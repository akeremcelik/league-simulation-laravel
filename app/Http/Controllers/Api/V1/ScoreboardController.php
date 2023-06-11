<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ScoreboardResource;
use App\Models\League;
use App\Services\ScoreboardService;
use Illuminate\Http\Request;

class ScoreboardController extends Controller
{
    public function getScoreboard(League $league)
    {
        $scoreboard = (new ScoreboardService($league))->getScoreboard();

        return ScoreboardResource::collection($scoreboard);
    }
}
