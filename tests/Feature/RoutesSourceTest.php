<?php

namespace Tests\Feature;

use App\Generators\Source\GeneratorRepository;
use App\Generators\Source\RoutesSource;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class RoutesSourceTest extends TestCase
{
    public function test_handles_routes()
    {
        File::shouldReceive('get')
            ->andReturn('<?php Route::get("baz") ');

        File::shouldReceive('put')
            ->withArgs(function ($filePath, $content) {
                $this->assertStringContainsString("Route::get('/projects/{project}/sources/foo_bar/create', 'create')", $content);

                return true;
            });

        $generator = new GeneratorRepository();
        $generator->setup('Foo Bar', 'Some Response Type', 'Some Description', false);

        $transformer = new RoutesSource();
        $transformer->handle($generator);
    }
}
