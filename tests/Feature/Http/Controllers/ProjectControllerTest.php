<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Facades\App\Tools\ChatRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ProjectControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index()
    {
        $team = Team::factory()->create();

        Sanctum::actingAs(
            $user = User::factory()->create([
                'current_team_id' => $team->id,
            ]),
            ['view-tasks']
        );

        Project::factory()
            ->count(3)
            ->create([
                'team_id' => $user->current_team_id,
            ]);

        Project::factory()->create();

        $this->get(route('projects.index'))
            ->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Projects/Index')
                ->has('projects.data', 3)
            );
    }

    public function test_chat_controller()
    {
        $this->markTestSkipped('@TODO this should not be incharge of this anymore');
        ChatRepository::shouldReceive('handle')->once();
        $user = User::factory()->create();
        $project = Project::factory()->create();
        $this->actingAs($user)->post(route('projects.chat', [
            'project' => $project->id,
        ]), [
            'question' => 'foobar',
        ])->assertStatus(200);
    }

    public function test_show()
    {
        $team = Team::factory()->create();

        Sanctum::actingAs(
            $user = User::factory()->create([
                'current_team_id' => $team->id,
            ]),
            ['view-tasks']
        );

        $model = Project::factory()->create([
            'team_id' => $user->current_team_id,
        ]);

        $this->get(route('projects.show', [
            'project' => $model->id,
        ]))
            ->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Projects/Show'));
    }

    public function test_edit()
    {
        $team = Team::factory()->create();

        Sanctum::actingAs(
            $user = User::factory()->create([
                'current_team_id' => $team->id,
            ]),
            ['view-tasks']
        );

        $model = Project::factory()->create([
            'team_id' => $team->id,
        ]);

        $this->get(route('projects.edit', [
            'project' => $model->id,
        ]))
            ->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Projects/Edit'));
    }

    public function test_update()
    {
        $team = Team::factory()->create();

        Sanctum::actingAs(
            $user = User::factory()->create([
                'current_team_id' => $team->id,
            ]),
            ['view-tasks']
        );

        $model = Project::factory()->create([
            'team_id' => $team->id,
        ]);

        $this->actingAs($user)->put(route('projects.update', [
            'project' => $model->id,
        ]), [
            'name' => 'foobar',
            'active' => 1,
            'team_id' => $team->id,
            'slug' => null,
            'web_page' => 1,
            'private' => 1,
            'password' => 'foobaz',
            'meta_data' => [],
        ])
            ->assertStatus(302)
            ->assertRedirect(route('projects.show', [
                'project' => $model->id,
            ]));
        $this->assertEquals([
            'password' => 'foobaz',
        ], $model->refresh()->meta_data);
        $this->assertEquals('foobar', $model->refresh()->name);
    }

    public function test_create()
    {
        $team = Team::factory()->create();

        Sanctum::actingAs(
            $user = User::factory()->create([
                'current_team_id' => $team->id,
            ]),
            ['view-tasks']
        );

        $this->get(route('projects.create'))
            ->assertStatus(200)
            ->assertInertia(fn (Assert $page) => $page
                ->component('Projects/Create'));
    }

    public function test_store()
    {
        $team = Team::factory()->create();

        Sanctum::actingAs(
            $user = User::factory()->create([
                'current_team_id' => $team->id,
            ]),
            ['view-tasks']
        );

        $this->assertDatabaseCount('projects', 0);
        $this->post(route('projects.create'), [
            'name' => 'foobar',
            'active' => 1,
            'slug' => null,
            'web_page' => 1,
            'private' => 1,
            'password' => 'foo',
            'meta_data' => [],
        ])
            ->assertStatus(302);

        $this->assertDatabaseCount('projects', 1);

        $model = Project::first();

        $this->assertNotNull($model->name);
        $this->assertNotNull($model->team_id);
        $this->assertNotNull($model->slug);

        $this->assertEquals([
            'password' => 'foo',
        ], $model->meta_data);
    }
}
