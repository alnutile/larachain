<?php

use App\Models\Outbound;
use App\Models\User;

it('should create and redirect', function () {
    $user = User::factory()->create();

    $outbound = Outbound::factory()->create();

    $this->assertDatabaseCount('response_types', 0);

    $this->actingAs($user)
        ->get(route('response_types.chat_gpt_retrieval.create', ['outbound' => $outbound->id]));

    $this->assertDatabaseCount('response_types', 1);
});
