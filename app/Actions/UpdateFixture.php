<?php

namespace App\Actions;

use App\Models\Fixture;

class UpdateFixture
{
    public Fixture $fixture;

    public function __construct(Fixture $fixture)
    {
        $this->fixture = $fixture;
    }

    public function handle(array $data): ?Fixture
    {
        $this->fixture->update($data);
        return $this->fixture->fresh();
    }
}
