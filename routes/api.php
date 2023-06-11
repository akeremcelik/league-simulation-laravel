<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\TeamController;
use App\Http\Controllers\Api\V1\FixtureController;
use App\Http\Controllers\Api\V1\PlayController;
use App\Http\Controllers\Api\V1\ScoreboardController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::get('teams', [TeamController::class, 'teams']);
    Route::post('generate-fixtures', [FixtureController::class, 'generateFixtures']);
    Route::post('leagues/{league}/play-next-week', [PlayController::class, 'playNextWeek']);
    Route::post('leagues/{league}/play-all-weeks', [PlayController::class, 'playAllWeeks']);
    Route::get('leagues/{league}/get-scoreboard', [ScoreboardController::class, 'getScoreboard']);
});
