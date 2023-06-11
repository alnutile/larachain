<?php

use App\Jobs\ProcessSourceJob;
use App\Models\Project;
use App\Models\Source;
use App\Models\User;
use Illuminate\Support\Facades\Queue;
use function Pest\Laravel\assertDatabaseCount;

it('should show the form for URL Source WebHook', function () {
    $user = User::factory()->withPersonalTeam()
        ->create();

    $user = $this->createTeam($user);

    $project = Project::factory()->create([
        'team_id' => $user->current_team_id,
    ]);

    $this->actingAs($user)
        ->get(route('sources.web_hook.create', [
            'project' => $project->id,
        ]))
        ->assertOk();
})->todo("generator made this and not ready yet to finish this part");

it('should allow you to edit WebHook', function () {
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
        ->get(route('sources.web_hook.edit', [
            'project' => $project->id,
            'source' => $source->id,
        ]))
        ->assertOk();
})->todo("generator made this and not ready yet to finish this part");;

it('should run WebHook', function () {
    Queue::fake();
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
        ->post(route('sources.web_hook.run', [
            'project' => $project->id,
            'source' => $source->id,
        ]))
        ->assertRedirectToRoute('projects.show', [
            'project' => $project->id,
        ]);

    Queue::assertPushed(ProcessSourceJob::class);
})->todo("generator made this and not ready yet to finish this part");;

it('should allow you to update WebHook', function () {
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
        ->put(route('sources.web_hook.update', [
            'project' => $project->id,
            'source' => $source->id,
        ]), [
            'name' => 'Foo',
            'meta_data' => [
                'url' => 'https://foo.bar',
            ],
            'description' => 'Bar',
        ])
        ->assertRedirectToRoute('projects.show', [
            'project' => $project->id,
        ]);

    expect($source->refresh()->name)->toBe('Foo');
})->todo("generator made this and not ready yet to finish this part");;

it('should create WebHook', function () {
    $user = User::factory()->withPersonalTeam()
        ->create();

    $user = $this->createTeam($user);

    $project = Project::factory()->create([
        'team_id' => $user->current_team_id,
    ]);

    assertDatabaseCount('sources', 0);

    $this->actingAs($user)
        ->post(route('sources.web_hook.store', [
            'project' => $project->id,
        ]), [
            'name' => 'Foo',
            'description' => 'Bar',
            'meta_data' => [
                'url' => 'https://foo.bar',
            ],
        ])
        ->assertRedirectToRoute('projects.show', [
            'project' => $project->id,
        ]);
    assertDatabaseCount('sources', 1);
})->todo("generator made this and not ready yet to finish this part");;
