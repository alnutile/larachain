<?php

use App\Models\Outbound;
use App\Models\ResponseType;
use App\Models\User;
use Facades\App\LLMModels\OpenAi\ClientWrapper;
use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseCount;

it('should create and redirect', function () {
    $user = User::factory()->create();

    $outbound = Outbound::factory()->create();

    assertDatabaseCount('response_types', 0);

    actingAs($user)
        ->get(route('response_types.chatapi.create', ['outbound' => $outbound->id]));

    assertDatabaseCount('response_types', 1);
});

it('chat api response', function () {

    ClientWrapper::shouldReceive('nonStreamProjectChat')
        ->once()
        ->andReturn('foobar');

    $user = User::factory()->create();

    $outbound = Outbound::factory()->chatUi()->create();

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
