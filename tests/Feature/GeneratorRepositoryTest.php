<?php

namespace Tests\Feature;

use App\Generators\ResponseType\GeneratorRepository;
use Facades\App\Generators\ResponseType\ControllerTransformer;
use Facades\App\Generators\ResponseType\EnumTransformer;
use Facades\App\Generators\ResponseType\LarachainConfigTransformer;
use Facades\App\Generators\ResponseType\ResponseTypeClassTransformer;
use Facades\App\Generators\ResponseType\RoutesTransformer;
use Facades\App\Generators\ResponseType\VueTransformer;
use Tests\TestCase;

class GeneratorRepositoryTest extends TestCase
{
    public function test_keys()
    {
        ControllerTransformer::shouldReceive('handle')->once();
        VueTransformer::shouldReceive('handle')->once();
        RoutesTransformer::shouldReceive('handle')->once();
        EnumTransformer::shouldReceive('handle')->once();
        LarachainConfigTransformer::shouldReceive('handle')->once();
        ResponseTypeClassTransformer::shouldReceive('handle')->once();
        $generator = new GeneratorRepository();

        $generator->setup('Foo Bar', 'Some Response Type', 'Some Description', false)->run();

        $this->assertEquals('foo_bar', $generator->getKey());
    }

    public function test_path()
    {
        ControllerTransformer::shouldReceive('handle')->once();
        VueTransformer::shouldReceive('handle')->once();
        RoutesTransformer::shouldReceive('handle')->once();
        EnumTransformer::shouldReceive('handle')->once();
        LarachainConfigTransformer::shouldReceive('handle')->once();
        ResponseTypeClassTransformer::shouldReceive('handle')->once();
        $generator = new GeneratorRepository();

        $generator->setup('Foo Bar', 'Some Response Type', 'Some Description', false)->run();

        $this->assertStringContainsString('STUBS/', $generator->getRootPathOrStubs());
    }
}
