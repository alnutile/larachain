<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Transformer;
use App\Models\User;
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
