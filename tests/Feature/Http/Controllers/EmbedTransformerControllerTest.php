<?php

use App\Models\Project;
use App\Models\User;
use function Pest\Laravel\assertDatabaseCount;

it('should create', function () {
    $user = User::factory()->withPersonalTeam()
        ->create();

    $user = $this->createTeam($user);

    $project = Project::factory()->create([
        'team_id' => $user->current_team_id,
    ]);

    assertDatabaseCount('transformers', 0);

    $this->actingAs($user)
        ->get(route('transformers.embed_transformer.create', [
            'project' => $project->id,
        ]))
        ->assertRedirectToRoute('projects.show', [
            'project' => $project->id,
        ]);
    assertDatabaseCount('transformers', 1);
});
