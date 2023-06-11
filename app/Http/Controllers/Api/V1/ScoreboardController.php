<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\ScoreboardResource;
use App\Models\League;
use Illuminate\Http\Request;

class ScoreboardController extends Controller
{
    public function getScoreboard(League $league)
    {
        $teams = $league->teams()->get()->sortByDesc(function ($team) {
           return $team->pivot->points();
        })->values();

        return ScoreboardResource::collection($teams);
    }
}
