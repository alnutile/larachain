<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\Transformer;
use App\Transformer\TransformerEnum;
use App\Transformer\Types\Html2Text;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class Html2TextTest extends TestCase
{
    use SharedSetupForPdfFile;

    public function test_parses()
    {
        $document = Document::factory()->html()->create();

        $transformerModel = Transformer::factory()->create([
            'type' => TransformerEnum::Html2Text,
        ]);

        Storage::fake('projects');

        $transformer = new Html2Text($document);
        $this->assertDatabaseCount('document_chunks', 0);
        $transformer->handle($transformerModel);
        $this->assertDatabaseCount('document_chunks', 1);

        $document = Document::first();
        $content = $document->content;

        $this->assertNotNull($content);

    }

    public function test_remove_unicode()
    {
        $contentBefore = <<<EOD
This should be here

This should be here
EOD;


        $contentAfter = <<<EOD
This should be here  This should be here
EOD;

        $document = Document::factory()->html()->create([
            'content' => $contentBefore,
            'guid' => fake()->uuid . ".html"
        ]);

        $transformerModel = Transformer::factory()->create([
            'type' => TransformerEnum::Html2Text,
        ]);

        Storage::fake('projects');

        $transformer = new Html2Text($document);
        $document = $transformer->handle($transformerModel);
        $documentChunk = $document->refresh()->document_chunks->first();
        $this->assertEquals($contentAfter, $documentChunk->content);

    }
}
