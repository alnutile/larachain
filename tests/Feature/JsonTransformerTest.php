<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\Source;
use App\Models\Transformer;
use App\Transformer\Types\JsonTransformer;
use Tests\TestCase;

class JsonTransformerTest extends TestCase
{
    public function test_runs_base_on_source()
    {
        /** @var Source $source */
        $source = Source::factory()
            ->webHook()
            ->create();

        $data = [
            'foo' => [
                'baz' => [
                    1,
                    2,
                    3,
                ],
            ],
            'boo' => [
                'foo',
                'bar',
            ],
        ];

        $document = Document::factory()->create([
            'source_id' => $source->id,
            'guid' => 'foo.json',
            'content' => json_encode($data),
        ]);

        /** @var Transformer $transformer */
        $transformerModel = Transformer::factory()->create([
            'project_id' => $source->project_id,
            'meta_data' => [
                'mappings' => ['foo.baz', 'boo'],
            ],
        ]);

        $this->assertDatabaseCount('document_chunks', 0);

        $transformer = new JsonTransformer($document);
        $transformer->handle($transformerModel);
        $this->assertDatabaseCount('document_chunks', 1);

        $document_chunk = $document->refresh()->document_chunks->first();

        $this->assertEquals(
            json_encode([
                'baz' => [1, 2, 3], 'boo' => ['foo', 'bar'],
            ]),
            $document_chunk->content
        );
    }
}
