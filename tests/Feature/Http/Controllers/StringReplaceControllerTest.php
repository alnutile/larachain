<?php

use App\Models\Outbound;
use App\Models\ResponseType;
use App\Models\User;

it('should create and redirect', function () {
    $user = User::factory()->create();

    $outbound = Outbound::factory()->create();

    $this->assertDatabaseCount('response_types', 0);

    $this->actingAs($user)
        ->get(route('response_types.string_replace.create', ['outbound' => $outbound->id]));

    $this->assertDatabaseCount('response_types', 1);
});

it('should do update to response type', function () {
    $user = User::factory()->create();

    $outbound = Outbound::factory()->create();

    $responseType = ResponseType::factory()
        ->chatUi()
        ->create([
            'outbound_id' => $outbound->id,
        ]);

    $this->actingAs($user)
        ->put(route('response_types.string_replace.update', [
            'outbound' => $outbound->id,
            'response_type' => $responseType->id,
        ]), [
            'meta_data' => [
                'search' => ['foo'],
                'replace' => ['bar'],
            ],
        ])->assertRedirectToRoute(
            'outbounds.chat_ui.show', [
                'outbound' => $outbound->id,
                'project' => $outbound->project->id,
            ]
        );

    $this->assertEquals('foo', $responseType->refresh()->meta_data['search'][0]);
    $this->assertEquals('bar', $responseType->refresh()->meta_data['replace'][0]);
});
