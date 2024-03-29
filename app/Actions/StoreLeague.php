<?php

namespace App\Actions;

use App\Models\League;

class StoreLeague
{
    public function handle(): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        return League::query()->create();
    }
}
