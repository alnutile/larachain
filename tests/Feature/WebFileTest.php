<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\Source;
use App\Source\Types\WebFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;

class WebFileTest extends TestCase
{
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

        $document = Document::first();

        $this->assertEquals('foo', $document->content);

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

        $document = Document::first();
        $this->assertEquals('foo.pdf', $document->guid);

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
