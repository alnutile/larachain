<?php

use App\Models\Project;
use App\Models\Source;
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

it('should allow you to edit', function () {
    $user = User::factory()->withPersonalTeam()
        ->create();

    $user = $this->createTeam($user);

    $project = Project::factory()->create([
        'team_id' => $user->current_team_id,
    ]);

    $source = Source::factory()->create([
        'project_id' => $project->id,
    ]);

    $this->actingAs($user)
        ->get(route('sources.web_file.edit', [
            'project' => $project->id,
            'source' => $source->id,
        ]))
        ->assertOk();
});

it('should allow you to update', function () {
    $user = User::factory()->withPersonalTeam()
        ->create();

    $user = $this->createTeam($user);

    $project = Project::factory()->create([
        'team_id' => $user->current_team_id,
    ]);

    $source = Source::factory()->create([
        'project_id' => $project->id,
    ]);

    $this->actingAs($user)
        ->put(route('sources.web_file.update', [
            'project' => $project->id,
            'source' => $source->id,
        ]), [
            'name' => 'Foo',
            'url' => 'http://foo.com',
            'description' => 'Bar',
        ])
        ->assertRedirectToRoute('projects.show', [
            'project' => $project->id,
        ]);

    expect($source->refresh()->name)->toBe('Foo');
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
