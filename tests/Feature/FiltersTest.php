<?php

namespace Tests\Feature;

use App\Data\Filters;
use Tests\TestCase;

class FiltersTest extends TestCase
{
    public function test_dto()
    {
        $dto = Filters::from([
            'sources' => [1, 2],
        ]);

        $this->assertNotEmpty($dto->sources);
    }
}
