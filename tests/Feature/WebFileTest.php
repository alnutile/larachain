<?php

namespace Tests\Feature;

use App\Models\Source;
use App\Source\Types\WebFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;

class WebFileTest extends TestCase
{
    use SharedSetupForPdfFile;

    public function test_gets_file()
    {
        $source = Source::factory()->webFileMetaData()->create();

        Storage::fake('projects');
        $webFileSourceType = new WebFile($source);

        Http::fake([
            'wikipedia.com/*' => Http::response('foo', 200),
        ]);

        $webFileSourceType->handle();

        Http::assertSentCount(1);

        $to = sprintf('%d/sources/%d/foo.pdf',
            $source->project_id, $source->id);
        Storage::disk('projects')->assertExists($to);

    }

    public function test_makes_document()
    {
        $source = Source::factory()->webFileMetaData()->create();

        Storage::fake('projects');
        $webFileSourceType = new WebFile($source);

        Http::fake([
            'wikipedia.com/*' => Http::response('foo', 200),
        ]);

        $this->assertDatabaseCount('documents', 0);
        $webFileSourceType->handle();

        $this->assertDatabaseCount('documents', 1);

    }

    public function test_makes_document_once()
    {
        $source = Source::factory()->webFileMetaData()->create();

        Storage::fake('projects');
        $webFileSourceType = new WebFile($source);

        Http::fake([
            'wikipedia.com/*' => Http::response('foo', 200),
        ]);

        $this->assertDatabaseCount('documents', 0);
        $webFileSourceType->handle();

        $this->assertDatabaseCount('documents', 1);
        $webFileSourceType->handle();
        $this->assertDatabaseCount('documents', 1);
    }

    protected function mockFunction($functionName, $returnValue)
    {
        $mock = Mockery::mock();
        $mock->shouldReceive('__invoke')->andReturn($returnValue);
        $this->app->instance($functionName, $mock);
    }
}
