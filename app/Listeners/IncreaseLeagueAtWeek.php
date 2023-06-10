<?php

namespace App\Listeners;

use App\Actions\UpdateLeague;
use App\Events\MatchPlayed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class IncreaseLeagueAtWeek
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(MatchPlayed $event)
    {
        $updateLeague = new UpdateLeague($event->league);
        $updateLeague->handle([
            'at_week' => $event->league->at_week+1,
        ]);
    }
}
