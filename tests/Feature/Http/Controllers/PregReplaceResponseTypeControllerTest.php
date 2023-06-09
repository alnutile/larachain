<?php

use App\Models\Outbound;
use App\Models\ResponseType;
use App\Models\User;

it('should create and redirect', function () {
    $user = User::factory()->create();

    $outbound = Outbound::factory()->create();

    $this->assertDatabaseCount('response_types', 0);

    $this->actingAs($user)
        ->get(route('response_types.preg_replace.create', ['outbound' => $outbound->id]));

    $this->assertDatabaseCount('response_types', 1);
});

it('should do update to response type', function () {
    $user = User::factory()->create();

    $outbound = Outbound::factory()->chatUi()->create();

    $responseType = ResponseType::factory()
        ->create([
            'outbound_id' => $outbound->id,
        ]);

    $this->actingAs($user)
        ->put(route('response_types.preg_replace.update', [
            'outbound' => $outbound->id,
            'response_type' => $responseType->id,
        ]), [
            'meta_data' => [
                'preg_replace_pattern' => "/\./",
                'preg_replace_replacement' => "''",
            ],
        ])->assertRedirectToRoute(
            'outbounds.chat_ui.show', [
                'outbound' => $outbound->id,
                'project' => $outbound->project->id,
            ]
        );

    $this->assertEquals("/\./", $responseType->refresh()->meta_data['preg_replace_pattern']);
    $this->assertEquals("''", $responseType->refresh()->meta_data['preg_replace_replacement']);
});
