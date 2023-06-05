<?php

use App\Models\Outbound;
use App\Models\Project;
use App\Models\User;

it('test shows create page API Outbound', function () {
    $user = User::factory()->withPersonalTeam()
        ->create();

    $user = $this->createTeam($user);

    $project = Project::factory()->create([
        'team_id' => $user->current_team_id,
    ]);

    $this->assertDatabaseCount('outbounds', 0);

    $this->actingAs($user)
        ->get(route('outbounds.api.create', [
            'project' => $project->id,
        ]))
        ->assertRedirectToRoute('outbounds.api.show', [
            'project' => $project->id,
            'outbound' => Outbound::first()->id,
        ]);
    $this->assertDatabaseCount('outbounds', 1);
});

it('test show Api Outbound', function () {
    $user = User::factory()->withPersonalTeam()
        ->create();

    $user = $this->createTeam($user);

    $project = Project::factory()->create([
        'team_id' => $user->current_team_id,
    ]);

    $outbound = Outbound::factory()->api()->create([
        'project_id' => $project->id,
    ]);

    $this->actingAs($user)
        ->get(route('outbounds.api.show', [
            'project' => $project->id,
            'outbound' => $outbound->id,
        ]))
        ->assertOk();
});
