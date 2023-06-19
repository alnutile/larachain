<?php

namespace Tests\Feature;

use App\Helpers\DataMapping;
use Tests\TestCase;

class DataMappingTest extends TestCase
{
    public function test_maps(): void
    {
        $data = [
            'foo' => [
                'baz' => [
                    1,
                    2,
                    3,
                ],
            ],
            'boo' => [
                'foo',
                'bar',
            ],
        ];

        $mapper = new DataMapping();
        $results = $mapper->map(['foo.baz', 'boo'], $data);

        $this->assertEquals([
            'baz' => [1, 2, 3], 'boo' => ['foo', 'bar'],
        ], $results);
    }
}
