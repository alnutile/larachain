<?php

namespace Tests\Feature;

use App\Generators\Outbound\GeneratorRepository;
use Facades\App\Generators\Outbound\ControllerOutboundGenerator;
//use Facades\App\Generators\Outbound\EnumOutbound;
//use Facades\App\Generators\Outbound\LarachainConfigOutbound;
use Facades\App\Generators\Outbound\OutboundClassGenerator;
use Facades\App\Generators\Outbound\RoutesOutbound;
use Facades\App\Generators\Outbound\VueOutbound;
use Tests\TestCase;

class OutboundGeneratorRepositoryTest extends TestCase
{
    public function test_keys()
    {
        ControllerOutboundGenerator::shouldReceive('handle')->once();
        VueOutbound::shouldReceive('handle')->once();
        RoutesOutbound::shouldReceive('handle')->once();
//        EnumOutbound::shouldReceive('handle')->once();
//        LarachainConfigOutbound::shouldReceive('handle')->once();
        OutboundClassGenerator::shouldReceive('handle')->once();
        $generator = new GeneratorRepository();

        $generator->setup('Foo Bar', 'Some Response Type', 'Some Description', false)->run();

        $this->assertEquals('foo_bar', $generator->getKey());
    }

    public function test_path()
    {
        ControllerOutboundGenerator::shouldReceive('handle')->once();
        VueOutbound::shouldReceive('handle')->once();
        RoutesOutbound::shouldReceive('handle')->once();
//        EnumOutbound::shouldReceive('handle')->once();
//        LarachainConfigOutbound::shouldReceive('handle')->once();
        OutboundClassGenerator::shouldReceive('handle')->once();
        $generator = new GeneratorRepository();

        $generator->setup('Foo Bar', 'Some Response Type', 'Some Description', false)->run();

        $this->assertStringContainsString('STUBS/', $generator->getRootPathOrStubs());
    }
}
