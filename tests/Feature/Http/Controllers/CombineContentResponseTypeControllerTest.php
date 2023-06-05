<?php

use App\Models\Outbound;
use App\Models\ResponseType;
use App\Models\User;

it('should create and to edit combine content', function () {
    $user = User::factory()->create();

    $outbound = Outbound::factory()->create();

    $this->assertDatabaseCount('response_types', 0);

    $this->actingAs($user)
        ->get(route('response_types.combine_content.create', ['outbound' => $outbound->id]));

    $this->assertDatabaseCount('response_types', 1);
});

it('should do update to response type', function () {
    $user = User::factory()->create();

    $outbound = Outbound::factory()->create();

    $responseType = ResponseType::factory()
        ->combineContent()
        ->create([
            'outbound_id' => $outbound->id,
        ]);

    $this->actingAs($user)
        ->put(route('response_types.combine_content.update', [
            'outbound' => $outbound->id,
            'response_type' => $responseType->id,
        ]), [
            'meta_data' => ['token_limit' => 4000],
        ])->assertRedirectToRoute(
            'outbounds.chat_ui.show', [
                'outbound' => $outbound->id,
                'project' => $outbound->project->id,
            ]
        );

    $this->assertEquals(4000, $responseType->refresh()->meta_data['token_limit']);
});
