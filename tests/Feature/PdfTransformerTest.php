<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\Source;
use App\Transformers\Types\EmbeddTranformer;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class PdfTransformerTest extends TestCase
{
    public function test_gets_data_from_pdf()
    {

        $source = Source::factory()
            ->webFileMetaData()
            ->create();

        $document = Document::factory()->create([
            'source_id' => $source->id,
            'guid' => 'example.pdf',
        ]);

        $from = base_path('tests/fixtures/example.pdf');

        File::copy(
            $from,
            $document->pathToFile()
        );

        $this->assertDatabaseCount('document_chunks', 0);
        $transformer = new EmbeddTranformer($document);
        $transformer->handle();
        $this->assertDatabaseCount('document_chunks', 10);

    }

    public function test_does_not_repeat()
    {
        $source = Source::factory()
            ->webFileMetaData()
            ->create();

        $document = Document::factory()->create([
            'source_id' => $source->id,
            'guid' => 'example.pdf',
        ]);

        $from = base_path('tests/fixtures/example.pdf');

        File::copy(
            $from,
            $document->pathToFile()
        );

        $this->assertDatabaseCount('document_chunks', 0);
        $transformer = new EmbeddTranformer($document);
        $transformer->handle();
        $this->assertDatabaseCount('document_chunks', 10);
        $transformer->handle();
        $this->assertDatabaseCount('document_chunks', 10);

    }
}
