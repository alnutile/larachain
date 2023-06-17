<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\Source;
use App\Models\Transformer;
use App\Transformer\Types\JsonTransformer;
use Tests\TestCase;

class JsonTransformerTest extends TestCase
{
    use SharedSetupForPdfFile;

    public function test_runs_base_on_source()
    {
        /** @var Source $source */
        $source = Source::factory()
            ->webHook()
            ->create();

        $document = Document::factory()->create([
            'source_id' => $source->id,
        ]);

        /** @var Transformer $transformer */
        $transformerModel = Transformer::factory()->create([
            'project_id' => $source->project_id,
        ]);

        $this->assertDatabaseCount('document_chunks', 0);

        $transformer = new JsonTransformer($document);
        $transformer->handle($transformerModel);
        $this->assertDatabaseCount('document_chunks', 1);
    }
}
