<?php

use App\Models\Project;
use App\Models\Transformer;
use App\Models\User;
use Illuminate\Support\Facades\Queue;

it('should create Html2Text', function () {
    $user = User::factory()->withPersonalTeam()
        ->create();

    $user = $this->createTeam($user);

    $project = Project::factory()->create([
        'team_id' => $user->current_team_id,
    ]);

    $this->assertDatabaseCount('transformers', 0);

    $this->actingAs($user)
        ->get(route('transformers.html2text.create', [
            'project' => $project->id,
        ]))
        ->assertRedirectToRoute('projects.show', [
            'project' => $project->id,
        ]);
    $this->assertDatabaseCount('transformers', 1);
});

it('should run transformer Html2Text', function () {
    $user = User::factory()->withPersonalTeam()
        ->create();

    $user = $this->createTeam($user);

    $project = Project::factory()->create([
        'team_id' => $user->current_team_id,
    ]);

    $transformer = Transformer::factory()->create(
        ['project_id' => $project->id]
    );

    Queue::fake();

    $this->actingAs($user)
        ->post(route('transformers.html2text.run', [
            'project' => $project->id,
            'transformer' => $transformer->id,
        ]))
        ->assertRedirectToRoute('projects.show', [
            'project' => $project->id,
        ]);
});
