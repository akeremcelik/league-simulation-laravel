<?php

namespace App\Actions;

use App\Models\Team;

class StoreTeam
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function handle(): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        $data = [
            'name' => $this->data['name'],
            'strength' => $this->data['strength'],
        ];

        return Team::query()->create($data);
    }
}
