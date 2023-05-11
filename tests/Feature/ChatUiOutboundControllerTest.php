<?php

use App\Models\Outbound;
use App\Models\Project;
use App\Models\User;
use function Pest\Laravel\assertDatabaseCount;

it('test shows create page', function () {
    $user = User::factory()->withPersonalTeam()
        ->create();

    $user = $this->createTeam($user);

    $project = Project::factory()->create([
        'team_id' => $user->current_team_id,
    ]);

    assertDatabaseCount('outbounds', 0);

    $this->actingAs($user)
        ->get(route('outbounds.chat_ui.create', [
            'project' => $project->id,
        ]))
        ->assertRedirectToRoute('outbounds.chat_ui.show', [
            'project' => $project->id,
            'outbound' => Outbound::first()->id,
        ]);
    assertDatabaseCount('outbounds', 1);
});

it('test show', function () {
    $user = User::factory()->withPersonalTeam()
        ->create();

    $user = $this->createTeam($user);

    $project = Project::factory()->create([
        'team_id' => $user->current_team_id,
    ]);

    $outbound = Outbound::factory()->create([
        'project_id' => $project->id,
    ]);

    $this->actingAs($user)
        ->get(route('outbounds.chat_ui.show', [
            'project' => $project->id,
            'outbound' => $outbound->id,
        ]))
        ->assertOk();
});
