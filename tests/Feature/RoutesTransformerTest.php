<?php

namespace Tests\Feature;

use App\Generators\ResponseType\GeneratorRepository;
use App\Generators\ResponseType\RoutesTransformer;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class RoutesTransformerTest extends TestCase
{
    public function test_handles_routes()
    {
        File::shouldReceive('get')
            ->andReturn('<?php Route::get("baz") ');

        File::shouldReceive('put')
            ->withArgs(function ($filePath, $content) {
                $this->assertStringContainsString("Route::get('/outbounds/{outbound}/response_types/foo_bar/create', 'create')", $content);

                return true;
            });

        $generator = new GeneratorRepository();
        $generator->setup('Foo Bar', 'Some Response Type', 'Some Description', false);

        $transformer = new RoutesTransformer();
        $transformer->handle($generator);
    }
}
