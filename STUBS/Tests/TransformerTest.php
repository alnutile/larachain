<?php

namespace Tests\Feature;

use Mockery;
use Tests\TestCase;
use App\Models\Source;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Source\Types\[RESOURCE_CLASS_NAME];

it('should create [RESOURCE_CLASS_NAME]', function () {
    $user = User::factory()->withPersonalTeam()
        ->create();

    $user = $this->createTeam($user);

    $project = Project::factory()->create([
        'team_id' => $user->current_team_id,
    ]);

    assertDatabaseCount('transformers', 0);

    $this->actingAs($user)
        ->get(route('transformers.[RESOURCE_KEY].create', [
            'project' => $project->id,
        ]))
        ->assertRedirectToRoute('projects.show', [
            'project' => $project->id,
        ]);
    assertDatabaseCount('transformers', 1);
});

it('should run transformer [RESOURCE_CLASS_NAME]', function () {
    $user = User::factory()->withPersonalTeam()
        ->create();

    $user = $this->createTeam($user);

    $project = Project::factory()->create([
        'team_id' => $user->current_team_id,
    ]);

    $transformer = Transformer::factory()->create(
        ['project_id' => $project->id]
    );

    $this->actingAs($user)
        ->post(route('transformers.[RESOURCE_KEY].run', [
            'project' => $project->id,
            'transformer' => $transformer->id,
        ]))
        ->assertRedirectToRoute('projects.show', [
            'project' => $project->id,
        ]);
});