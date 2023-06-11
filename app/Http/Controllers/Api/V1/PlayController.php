<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\League;
use App\Services\Play\PlayAllWeeks;
use App\Services\Play\PlayNextWeek;
use Illuminate\Http\Request;

class PlayController extends Controller
{
    public function playNextWeek(Request $request, League $league)
    {
        (new PlayNextWeek($league))->play();
    }

    public function playAllWeeks(Request $request, League $league)
    {
        (new PlayAllWeeks($league))->play();
    }
}
