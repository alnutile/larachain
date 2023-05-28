<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentChunk;
use App\Models\Source;
use App\Models\User;
use Tests\TestCase;

class DeleteSourceControllerTest extends TestCase
{
    public function test_delete()
    {
        //can user do it

        $user = User::factory()->create();

        $source = Source::factory()->create();

        $document = Document::factory()->create([
            'source_id' => $source->id,
        ]);

        DocumentChunk::factory()->count(5)->create([
            'document_id' => $document->id,
        ]);

        $this->assertDatabaseCount('sources', 1);
        $this->assertDatabaseCount('documents', 1);
        $this->assertDatabaseCount('document_chunks', 5);

        $this->actingAs($user)
            ->delete(route('sources.delete', [
                'source' => $source->id,
            ]))
            ->assertStatus(302);

        $this->assertDatabaseCount('sources', 0);
        $this->assertDatabaseCount('documents', 0);
        $this->assertDatabaseCount('document_chunks', 0);
    }
}
