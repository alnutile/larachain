<?php

use App\Models\Project;
use App\Models\User;
use function Pest\Laravel\assertDatabaseCount;

it('should show the form for URL Source type', function () {
    $user = User::factory()->withPersonalTeam()
        ->create();

    $user = $this->createTeam($user);

    $project = Project::factory()->create([
        'team_id' => $user->current_team_id,
    ]);

    $this->actingAs($user)
        ->get(route('sources.web_file.create', [
            'project' => $project->id,
        ]))
        ->assertOk();
});

it('should create', function () {
    $user = User::factory()->withPersonalTeam()
        ->create();

    $user = $this->createTeam($user);

    $project = Project::factory()->create([
        'team_id' => $user->current_team_id,
    ]);

    assertDatabaseCount('sources', 0);

    $this->actingAs($user)
        ->post(route('sources.web_file.store', [
            'project' => $project->id,
        ]), [
            'name' => 'Foo',
            'description' => 'Bar',
            'url' => 'https://foo.bar',
        ])
        ->assertRedirectToRoute('projects.show', [
            'project' => $project->id,
        ]);
    assertDatabaseCount('sources', 1);
});
