<?php

namespace App\Actions;

use App\Models\League;

class UpdateLeague
{
    public League $league;
    public array $data;

    public function __construct(League $league, array $data)
    {
        $this->league = $league;
        $this->data = $data;
    }

    public function handle(): ?League
    {
        $data = [
            'at_week' => $this->data['at_week'],
        ];

        $this->league->update($data);
        return $this->league->fresh();
    }
}
