<?php

namespace Tests\Feature;

use App\Generators\ResponseType\GeneratorRepository;
use App\Generators\ResponseType\VueTransformer;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class VueTransformerTest extends TestCase
{
    public function test_handles_vue()
    {
        File::shouldReceive('allFiles')->andReturn(
            [
                new \Symfony\Component\Finder\SplFileInfo('Edit.vue', '', 'foo.bar'),
                new \Symfony\Component\Finder\SplFileInfo('ResourceForm.vue', '', 'foo.bar'),
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

        $transformer = new VueTransformer();
        $transformer->handle($generator);
    }
}
