<?php

namespace Tests\Feature\Models;

use App\Models\DocumentChunk;
use Tests\TestCase;

class DocumentChunkTest extends TestCase
{
    public function test_dc_factory()
    {
        $model = DocumentChunk::factory()->create();
        $this->assertNotNull($model->content);
    }

    public function test_original_boot()
    {
        $model = DocumentChunk::factory()->create([
            'content' => 'baz boo',
        ]);
        $model->update([
            'content' => 'foo bar',
        ]);
        $this->assertEquals('baz boo', $model->original_content);
    }

    public function test_dc_rel()
    {
        $model = DocumentChunk::factory()->create();
        $this->assertNotNull($model->document->id);
        $this->assertNotNull($model->document->document_chunks->first()->id);
    }
}
