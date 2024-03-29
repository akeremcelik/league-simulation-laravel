<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class FixtureResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'league_id' => $this->league_id,
            'week' => $this->week,
            'home_team' => TeamResource::make($this->home_team),
            'away_team' => TeamResource::make($this->away_team),
            'played' => $this->played,
            'home_team_score' => $this->home_team_score,
            'away_team_score' => $this->away_team_score,
        ];
    }
}
