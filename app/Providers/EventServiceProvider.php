<?php

namespace App\Providers;

use App\Events\MatchPlayed;
use App\Events\WeekPlayed;
use App\Listeners\IncreaseLeagueAtWeek;
use App\Listeners\UpdateTeamScoreboard;
use App\Models\League;
use App\Observers\LeagueObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        MatchPlayed::class => [
            UpdateTeamScoreboard::class,
        ],
        WeekPlayed::class => [
            IncreaseLeagueAtWeek::class,
        ],
    ];

    /**
     * The model observers for your application.
     *
     * @var array
     */
    protected $observers = [
        League::class => [LeagueObserver::class],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     *
     * @return bool
     */
    public function shouldDiscoverEvents()
    {
        return false;
    }
}
