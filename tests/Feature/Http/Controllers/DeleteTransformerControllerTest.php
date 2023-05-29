<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentChunk;
use App\Models\Source;
use App\Models\Transformer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteTransformerControllerTest extends TestCase
{
    public function test_delete()
    {
        $user = User::factory()->create();

        $transformer = Transformer::factory()->create();

        $this->assertDatabaseCount('transformers', 1);

        $this->actingAs($user)
            ->delete(route('transformers.delete', [
                'transformer' => $transformer->id,
            ]))
            ->assertStatus(302);

        $this->assertDatabaseCount('transformers', 0);
    }
}
