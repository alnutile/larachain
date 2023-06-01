<?php

namespace Tests\Feature;

use App\Generators\Source\GeneratorRepository;
use Tests\TestCase;

class BaseRepositoryTest extends TestCase
{
    public function test_naming()
    {
        $baseRepo = new GeneratorRepository();
        $baseRepo->setup('FooBarBazBoo', 'Foo bar', false);

        $this->assertEquals('foo_bar_baz_boo', $baseRepo->getKey());
    }
}
