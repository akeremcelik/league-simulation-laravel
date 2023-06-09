<?php

namespace App\Actions;

use App\Models\Team;

class StoreTeam
{
    protected string $name;
    protected int $strength;

    public function __construct($name, $strength)
    {
        $this->name = $name;
        $this->strength = $strength;
    }

    public function handle(): \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
    {
        $data = [
            'name' => $this->name,
            'strength' => $this->strength,
        ];

        return Team::query()->create($data);
    }
}
