<?php

namespace Tests\Feature;

use App\Generators\ResponseType\GeneratorRepository;
use App\Generators\ResponseType\LarachainConfigTransformer;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class LarachainConfigTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->markTestSkipped('Need to better mock writing of the file');
    }

    public function test_handles_config()
    {
        $config = File::get(base_path('tests/fixtures/larachain.php'));
        $generator = new GeneratorRepository();
        $generator->setup('Foo Bar', 'Some Response Type', 'Some Description', false);

        File::shouldReceive('get')
            ->andReturn($config);

        File::shouldReceive('put')
            ->withArgs(function ($filePath, $content) use ($generator) {
                $this->assertStringContainsString($generator->name, $content);
                $this->assertStringContainsString($generator->getKey(), $content);
                $this->assertStringContainsString('App\\\ResponseType\\\Types\\\FooBar', $content);
                $this->assertStringContainsString($generator->description, $content);

                return true;
            });

        $transformer = new LarachainConfigTransformer();
        $transformer->handle($generator);
    }
}
