<?php

namespace Tests\Feature;

use App\Source\SourceTypeEnum;
use Tests\TestCase;

class SourceTypeEnumTest extends TestCase
{
    public function test_to_array()
    {
        $results = SourceTypeEnum::toArray();
        expect($results['web_file']['name'])->toBe('Web File Source Type');
    }
}
