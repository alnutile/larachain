<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Outbound;
use App\Models\ResponseType;
use App\Models\User;
use Tests\TestCase;

class DeleteOutboundControllerTest extends TestCase
{
    public function test_delete()
    {
        $user = User::factory()->create();

        $outbound = Outbound::factory()->create();

        ResponseType::factory()->count(4)->create([
            'outbound_id' => $outbound->id,
        ]);

        $this->assertDatabaseCount('outbounds', 1);
        $this->assertDatabaseCount('response_types', 4);

        $this->actingAs($user)
            ->delete(route('outbounds.delete', [
                'outbound' => $outbound->id,
            ]))
            ->assertStatus(302);

        $this->assertDatabaseCount('outbounds', 0);
        $this->assertDatabaseCount('response_types', 0);
    }
}
