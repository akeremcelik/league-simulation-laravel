<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\League;
use App\Services\PlayService;
use Illuminate\Http\Request;

class PlayController extends Controller
{
    public function playWeek(Request $request, League $league, $week)
    {
        (new PlayService())->playWeek($league, $week);
    }
}
