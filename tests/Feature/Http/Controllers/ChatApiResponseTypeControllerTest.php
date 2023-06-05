<?php

use App\Models\Outbound;
use App\Models\Project;
use App\Models\ResponseType;
use App\Models\User;
use Facades\App\LLMModels\OpenAi\ClientWrapper;

it('should create and redirect', function () {
    $user = User::factory()->create();

    $outbound = Outbound::factory()->create();

    $this->assertDatabaseCount('response_types', 0);

    $this->actingAs($user)
        ->get(route('response_types.chatapi.create', ['outbound' => $outbound->id]));

    $this->assertDatabaseCount('response_types', 1);
});

it('chat api response', function () {

    ClientWrapper::shouldReceive('nonStreamProjectChat')
        ->once()
        ->andReturn('foobar');

    $project = Project::factory()->create();

    $outbound = Outbound::factory()->api()->create([
        'project_id' => $project->id,
    ]);

    $user = User::factory()->create();

    $responseType = ResponseType::factory()
        ->chatApi()
        ->create([
            'outbound_id' => $outbound->id,
        ]);

    $this->actingAs($user)
        ->get(route('api.outbound.response_types.chat_api', [
            'outbound' => $outbound->id,
            'response_type' => $responseType->id,
            'question' => 'foo bar',
        ]))->assertJson(['data' => 'foobar']);
});

it('should do update to response type', function () {
    $user = User::factory()->create();

    $outbound = Outbound::factory()->chatUi()->create();

    $responseType = ResponseType::factory()
        ->create([
            'outbound_id' => $outbound->id,
        ]);

    $this->actingAs($user)
        ->put(route('response_types.chatapi.update', [
            'outbound' => $outbound->id,
            'response_type' => $responseType->id,
        ]), [
            'prompt_text' => 'foo bar',
        ]);

    expect($responseType->refresh()
        ->prompt_token['system'])->toBe('foo bar');
});
