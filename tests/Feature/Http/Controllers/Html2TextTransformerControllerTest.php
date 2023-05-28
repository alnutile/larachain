<?php

use App\Models\User;
use App\Models\Project;
use App\Models\Transformer;
use Illuminate\Support\Facades\Queue;
use function Pest\Laravel\assertDatabaseCount;

it('should create Html2Text', function () {
    $user = User::factory()->withPersonalTeam()
        ->create();

    $user = $this->createTeam($user);

    $project = Project::factory()->create([
        'team_id' => $user->current_team_id,
    ]);

    assertDatabaseCount('transformers', 0);

    $this->actingAs($user)
        ->get(route('transformers.html2text.create', [
            'project' => $project->id,
        ]))
        ->assertRedirectToRoute('projects.show', [
            'project' => $project->id,
        ]);
    assertDatabaseCount('transformers', 1);
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
