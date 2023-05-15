<?php

namespace Tests\Feature;

use App\Generators\ResponseType\GeneratorRepository;
use App\Generators\ResponseType\ResponseTypeClassTransformer;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class ResponseTypeClassTransformerTest extends TestCase
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

        $controllerGenerator = new ResponseTypeClassTransformer();
        $controllerGenerator->handle($generator);
    }
}
