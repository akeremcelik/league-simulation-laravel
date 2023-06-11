<?php

namespace App\Actions;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class UpdateLeagueTeam
{
    protected Model|Builder $leagueTeam;

    public function __construct(Model|Builder $leagueTeam)
    {
        $this->leagueTeam = $leagueTeam;
    }

    public function handle(array $data): ?Model
    {
        $this->leagueTeam->update($data);
        return $this->leagueTeam->fresh();
    }
}
