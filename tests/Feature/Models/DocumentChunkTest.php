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

    public function test_dc_rel()
    {
        $model = DocumentChunk::factory()->create();
        $this->assertNotNull($model->document->id);
        $this->assertNotNull($model->document->document_chunks->first()->id);
    }
}
