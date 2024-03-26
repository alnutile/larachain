<?php

namespace Tests\Feature\Http\Controllers;

use App\Jobs\ProcessSourceJob;
use App\Models\Project;
use App\Models\Source;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileUploadSourcesSourceControllerTest extends TestCase
{
    public function test_shows_form()
    {
        $user = User::factory()->withPersonalTeam()->create();

        $user = $this->createTeam($user);

        $project = Project::factory()->create([
            'team_id' => $user->current_team_id,
        ]);

        $this->actingAs($user)
            ->get(route('sources.file_upload_source.create', [
                'project' => $project->id,
            ]))->assertOk();
    }

    public function test_create_file_upload()
    {

        Storage::fake('projects');

        $user = User::factory()->withPersonalTeam()
            ->create();

        $user = $this->createTeam($user);

        $project = Project::factory()->create([
            'team_id' => $user->current_team_id,
        ]);

        $this->assertDatabaseCount('sources', 0);

        $this->actingAs($user)
            ->post(route('sources.file_upload_source.store', [
                'project' => $project->id,
            ]), [
                'name' => 'Foo',
                'file' => UploadedFile::fake()->image('test.csv'),
                'description' => 'Bar',
            ])
            ->assertRedirectToRoute('projects.show', [
                'project' => $project->id,
            ]);
        $this->assertDatabaseCount('sources', 1);

        $source = $project->refresh()->sources->first();

        $path = sprintf('%d/sources/%d/%s',
            $source->project_id, $source->id, 'test.csv');
        Storage::disk('projects')->assertExists($path);
        $this->assertEquals('test.csv', $source->meta_data['file_name']);
    }

    public function testShouldAllowYouToUpdateFileUploadSource()
    {
        Storage::fake('projects');

        $user = User::factory()->withPersonalTeam()
            ->create();

        $user = $this->createTeam($user);

        $project = Project::factory()->create([
            'team_id' => $user->current_team_id,
        ]);

        $source = Source::factory()->create([
            'project_id' => $project->id,
            'meta_data' => [
                'file_name' => 'test.csv',
            ],
        ]);

        $response = $this->actingAs($user)
            ->put(route('sources.file_upload_source.update', [
                'project' => $project->id,
                'source' => $source->id,
            ]), [
                'name' => 'Foo',
                'file' => UploadedFile::fake()->image('test.csv'),
                'description' => 'Bar',
            ]);

        $response->assertRedirect(route('projects.show', [
            'project' => $project->id,
        ]));

        $path = sprintf('%d/sources/%d/%s',
            $source->project_id, $source->id, 'test.csv');
        Storage::disk('projects')->assertExists($path);
        $this->assertEquals('test.csv', $source->refresh()->meta_data['file_name']);
    }

    public function testShouldAllowYouToEditFileUploadSource()
    {
        $user = User::factory()->withPersonalTeam()
            ->create();

        $user = $this->createTeam($user);

        $project = Project::factory()->create([
            'team_id' => $user->current_team_id,
        ]);

        $source = Source::factory()->create([
            'project_id' => $project->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('sources.file_upload_source.edit', [
                'project' => $project->id,
                'source' => $source->id,
            ]));

        $response->assertOk();
    }

    public function testShouldRunFileUploadSource()
    {
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

        $response = $this->actingAs($user)
            ->post(route('sources.file_upload_source.run', [
                'project' => $project->id,
                'source' => $source->id,
            ]));

        $response->assertRedirect(route('projects.show', [
            'project' => $project->id,
        ]));

        Queue::assertPushed(ProcessSourceJob::class);
    }
}
