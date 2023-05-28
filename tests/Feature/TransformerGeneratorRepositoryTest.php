<?php

namespace Tests\Feature;

use App\Generators\Transformer\GeneratorRepository;
use Facades\App\Generators\Transformer\ControllerTransformerGenerator;
use Facades\App\Generators\Transformer\EnumTransformer;
use Facades\App\Generators\Transformer\LarachainConfigTransformer;
use Facades\App\Generators\Transformer\RoutesTransformer;
use Facades\App\Generators\Transformer\TransformerClassGenerator;
use Facades\App\Generators\Transformer\VueTransformer;
use Tests\TestCase;

class TransformerGeneratorRepositoryTest extends TestCase
{
    public function test_keys()
    {
        ControllerTransformerGenerator::shouldReceive('handle')->once();
        VueTransformer::shouldReceive('handle')->never();
        RoutesTransformer::shouldReceive('handle')->once();
        EnumTransformer::shouldReceive('handle')->once();
        LarachainConfigTransformer::shouldReceive('handle')->once();
        TransformerClassGenerator::shouldReceive('handle')->once();
        $generator = new GeneratorRepository();

        $generator->setup('Foo Bar', 'Some Response Type', 'Some Description', false)->run();

        $this->assertEquals('foo_bar', $generator->getKey());
    }

    // public function test_path()
    // {
    //     ControllerTransformer::shouldReceive('handle')->once();
    //     VueTransformer::shouldReceive('handle')->once();
    //     RoutesTransformer::shouldReceive('handle')->once();
    //     EnumTransformer::shouldReceive('handle')->once();
    //     LarachainConfigTransformer::shouldReceive('handle')->once();
    //     ResponseTypeClassTransformer::shouldReceive('handle')->once();
    //     $generator = new GeneratorRepository();

    //     $generator->setup('Foo Bar', 'Some Response Type', 'Some Description', false)->run();

    //     $this->assertStringContainsString('STUBS/', $generator->getRootPathOrStubs());
    // }
}
