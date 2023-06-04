<?php

namespace Tests\Feature;

use App\Source\SourceEnum;
use Tests\TestCase;

class SourceEnumTest extends TestCase
{
    public function test_to_array()
    {
        $results = SourceEnum::toArray();
        expect($results['web_file']['name'])->toBe('Web File Source Type');
    }
}
