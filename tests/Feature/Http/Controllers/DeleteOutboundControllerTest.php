<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentChunk;
use App\Models\Outbound;
use App\Models\ResponseType;
use App\Models\Source;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteOutboundControllerTest extends TestCase
{
    public function test_delete()
    {
        $user = User::factory()->create();

        $outbound = Outbound::factory()->create();

        ResponseType::factory()->count(4)->create([
            'outbound_id' => $outbound->id
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
