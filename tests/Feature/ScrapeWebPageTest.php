<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\Source;
use App\Source\Types\ScrapeWebPage;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ScrapeWebPageTest extends TestCase
{
    public function test_saves_content()
    {
        $source = Source::factory()->scrapeWebPage()->create();

        $webFileSourceType = new ScrapeWebPage($source);

        $html = 'Foo bar';

        Http::fake([
            'wikipedia.org/*' => Http::response($html, 200),
        ]);

        $webFileSourceType->handle();

        $document = Document::first();

        $this->assertNotNull($document->content);
        $this->assertEquals($html, $document->content);

    }

    public function test_makes_document()
    {
        $source = Source::factory()->scrapeWebPage()->create();

        $webFileSourceType = new ScrapeWebPage($source);

        $html = 'Foo bar';

        Http::fake([
            'wikipedia.org/*' => Http::response($html, 200),
        ]);

        $this->assertDatabaseCount('documents', 0);

        $webFileSourceType->handle();

        $this->assertDatabaseCount('documents', 1);

    }

    public function test_makes_document_once_with_name()
    {
        $source = Source::factory()->scrapeWebPage()->create();

        $webFileSourceType = new ScrapeWebPage($source);

        $html = 'Foo bar';

        Http::fake([
            'wikipedia.org/*' => Http::response($html, 200),
        ]);

        $this->assertDatabaseCount('documents', 0);
        $webFileSourceType->handle();

        $this->assertDatabaseCount('documents', 1);

        $document = Document::first();
        $this->assertEquals('Laravel.html', $document->guid);

        $webFileSourceType->handle();
        $this->assertDatabaseCount('documents', 1);
    }
}
