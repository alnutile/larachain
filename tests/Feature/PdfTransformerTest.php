<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\Source;
use App\Transformers\Types\PdfTransformer;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PdfTransformerTest extends TestCase
{
    public function test_gets_data_from_pdf()
    {

        $this->markTestSkipped('Need to do document chunks first');

        $source = Source::factory()
            ->webFileMetaData()
            ->create();

        Storage::disk('projects')->copy(
            base_path('tests/fixtures/example.pdf'),
            sprintf(storage_path('app/projects/%d/sources/%d/example.pdf',
            $source->project_id, $source->id))
        );

        $document = Document::factory()->create([
            'source_id' => $source->id,
            'guid' => 'example.pdf',
        ]);

        $trasformer = new PdfTransformer($document);

    }
}
