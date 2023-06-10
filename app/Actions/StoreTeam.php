<?php

namespace App\Actions;

use App\Models\Team;

class StoreTeam
{
    public function handle(array $data): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        return Team::query()->create($data);
    }
}
