<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\File;
use App\Generators\Transformer\GeneratorRepository;
use App\Generators\Transformer\ControllerTransformerGenerator;

class ControllerTransformerGeneratorTest extends TestCase
{
    public function test_copies_to_folders()
    {
        File::shouldReceive('makeDirectory')->andReturnTrue();
        File::shouldReceive('exists')->andReturnTrue();
        File::shouldReceive('allFiles')->andReturn(
            [
                new \Symfony\Component\Finder\SplFileInfo('Foo.vue', '', 'foo.bar'),
            ]
        );

        File::shouldReceive('get')
            ->andReturn('[RESOURCE_CLASS_NAME]');
        File::shouldReceive('put')
            ->withArgs(function ($filePath, $content) {
                $this->assertStringContainsString('FooBar', $content);

                return true;
            });
        $generator = new GeneratorRepository();
        $generator->setup('Foo Bar', 'Some Response Type', 'Some Description', false);

        $controllerGenerator = new ControllerTransformerGenerator();
        $controllerGenerator->handle($generator);
    }
}
