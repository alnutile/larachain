<?php

use App\Models\Outbound;
use App\Models\Project;
use App\Models\User;
use App\Outbound\OutboundEnum;
use Illuminate\Support\Facades\File;
use function Pest\Laravel\assertDatabaseCount;

it('test shows create page ChatGptRetrieval Outbound', function () {
    $user = User::factory()->withPersonalTeam()
        ->create();

    $user = $this->createTeam($user);

    $project = Project::factory()->create([
        'team_id' => $user->current_team_id,
    ]);

    assertDatabaseCount('outbounds', 0);

    $this->actingAs($user)
        ->get(route('outbounds.chat_gpt_retrieval.create', [
            'project' => $project->id,
        ]))
        ->assertRedirectToRoute('outbounds.chat_gpt_retrieval.show', [
            'project' => $project->id,
            'outbound' => Outbound::first()->id,
        ]);
    assertDatabaseCount('outbounds', 1);
});

it('test show ChatGptRetrieval Outbound', function () {
    $user = User::factory()->withPersonalTeam()
        ->create();

    $user = $this->createTeam($user);

    $project = Project::factory()->create([
        'team_id' => $user->current_team_id,
    ]);

    $outbound = Outbound::factory()->create([
        'type' => OutboundEnum::ChatGptRetrieval,
        'project_id' => $project->id,
    ]);

    $this->actingAs($user)
        ->get(route('outbounds.chat_gpt_retrieval.show', [
            'project' => $project->id,
            'outbound' => $outbound->id,
        ]))
        ->assertOk();
});

it('test openapi yaml', function () {
    $user = User::factory()->withPersonalTeam()
        ->create();

    $user = $this->createTeam($user);

    $project = Project::factory()->create([
        'team_id' => $user->current_team_id,
    ]);

    $outbound = Outbound::factory()->create([
        'type' => OutboundEnum::ChatGptRetrieval,
        'project_id' => $project->id,
    ]);
    $openaiApi = File::get(base_path('tests/fixtures/openapi.yaml'));
    $this->actingAs($user)
        ->get(route('api.outbounds.chat_gpt_retrieval.openapi', [
            'project' => $project->id,
            'outbound' => $outbound->id,
        ]))
        ->assertOk();
});
