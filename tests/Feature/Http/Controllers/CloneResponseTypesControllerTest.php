<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Outbound;
use App\Models\ResponseType;
use App\Models\User;
use Tests\TestCase;

class CloneResponseTypesControllerTest extends TestCase
{
    public function test_clone()
    {
        $from = Outbound::factory()->chatUi()->create();
        ResponseType::factory()->count(2)->create([
            'outbound_id' => $from->id,
        ]);

        $to = Outbound::factory()->api()->create();

        $user = User::factory()->create();
        $this->actingAs($user)
            ->post(route('outbounds.clone.response_types'), [
                'from' => $from->id,
                'to' => $to->id,
            ])->assertRedirectToRoute('outbounds.api.show', [
                'outbound' => $to->id,
                'project' => $to->project_id,
            ]);
        $this->assertCount(2, $to->refresh()->response_types);
        $this->assertDatabaseCount('response_types', 4);
    }
}
