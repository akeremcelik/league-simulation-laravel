<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\TeamResource;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function teams(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $teams = Team::all();

        return TeamResource::collection($teams);
    }
}
