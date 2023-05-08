<?php

namespace Tests\Feature;

use App\Models\Source;
use App\Source\Types\WebFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Mockery;
use Tests\TestCase;

class WebFileSourceTypeTest extends TestCase
{
    public function test_gets_file()
    {
        $source = Source::factory()->webFileMetaData()->create();

        Storage::fake('projects');
        $webFileSourceType = new WebFile($source);

        $fileName = 'test.pdf';

        // Fake the file_get_contents function to return the test file contents
        Http::fake([
            'wikipedia.com/*' => Http::response('foo', 200),
        ]);

        $webFileSourceType->handle();

        ///var/www/html/storage/projects/1/source/1/foo.pdf
        ///var/www/html/storage/projects/1/source/1/foo.pdf
        Storage::disk('projects')->assertExists(
            sprintf('%d/sources/%d/%s',
            $source->project_id, $source->id, $fileName));

    }

    public function test_triggers_document_job()
    {
        $source = Source::factory()->webFileMetaData()->create();

        Storage::fake('projects');
        $webFileSourceType = new WebFile($source);

        $fileName = 'test.pdf';

        // Fake the file_get_contents function to return the test file contents
        Http::fake([
            'wikipedia.com/*' => Http::response('foo', 200),
        ]);

        $webFileSourceType->handle();

        ///var/www/html/storage/projects/1/source/1/foo.pdf
        ///var/www/html/storage/projects/1/source/1/foo.pdf
        Storage::disk('projects')->assertExists(
            sprintf('%d/sources/%d/%s',
                $source->project_id, $source->id, $fileName));

    }

    protected function mockFunction($functionName, $returnValue)
    {
        $mock = Mockery::mock();
        $mock->shouldReceive('__invoke')->andReturn($returnValue);
        $this->app->instance($functionName, $mock);
    }
}
