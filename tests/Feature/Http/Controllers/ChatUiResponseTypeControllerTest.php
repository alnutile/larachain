<?php

use App\Models\Outbound;
use App\Models\Project;
use App\Models\ResponseType;
use App\Models\User;
use function Pest\Laravel\assertDatabaseCount;

it('should create', function () {

    $user = User::factory()->withPersonalTeam()
        ->create();

    $user = $this->createTeam($user);

    $project = Project::factory()->create([
        'team_id' => $user->current_team_id,
    ]);

    $outbound = Outbound::factory()->create(
        ['project_id' => $project->id]
    );

    assertDatabaseCount('response_types', 0);

    $this->actingAs($user)
        ->get(route('response_types.chat_ui.create', [
            'outbound' => $outbound->id,
        ]))->assertRedirectToRoute(
            'response_types.chat_ui.edit', [
                'response_type' => ResponseType::first()->id,
                'outbound' => $outbound->id,
            ]
        );
    assertDatabaseCount('response_types', 1);
});

it('can update prompt', function () {

    $user = User::factory()->withPersonalTeam()
        ->create();

    $user = $this->createTeam($user);

    $project = Project::factory()->create([
        'team_id' => $user->current_team_id,
    ]);

    $outbound = Outbound::factory()->create(
        ['project_id' => $project->id]
    );

    $responseType = ResponseType::factory()
        ->chatUi()
        ->create([
            'outbound_id' => $outbound->id,
        ]);

    $this->actingAs($user)
        ->put(route('response_types.chat_ui.update', [
            'outbound' => $outbound->id,
            'response_type' => $responseType->id,
        ]), [
            'prompt_text' => 'foo bar',
        ]);

    expect($responseType->refresh()
        ->prompt_token['system'])->toBe('foo bar');
});
