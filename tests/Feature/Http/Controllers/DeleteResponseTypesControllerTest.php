<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\ResponseType;
use App\Models\User;
use Tests\TestCase;

class DeleteResponseTypesControllerTest extends TestCase
{
    public function test_delete()
    {
        $user = User::factory()->create();

        $responseType = ResponseType::factory()->create();

        $this->assertDatabaseCount('response_types', 1);

        $this->actingAs($user)
            ->delete(route('response_types.delete', [
                'response_type' => $responseType->id,
            ]))
            ->assertStatus(302);

        $this->assertDatabaseCount('response_types', 0);
    }
}
