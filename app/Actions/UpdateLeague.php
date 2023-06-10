<?php

namespace App\Actions;

use App\Models\League;

class UpdateLeague
{
    public League $league;

    public function __construct(League $league)
    {
        $this->league = $league;
    }

    public function handle(array $data): ?League
    {
        $this->league->update($data);
        return $this->league->fresh();
    }
}
