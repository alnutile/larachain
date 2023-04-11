<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Project;
use App\Models\Team;
use App\Models\User;
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
                'current_team_id' => $team->id
            ]),
            ['view-tasks']
        );

        Project::factory()
            ->count(3)
            ->create([
                'team_id' => $user->current_team_id
            ]);

        Project::factory()->create();

        $this->get(route('projects.index'))
            ->assertStatus(200)
            ->assertInertia(fn(Assert $page) => $page
                ->component('Projects/Index')
                ->has("projects.data", 3)
            );
    }

    public function test_show()
    {
        $team = Team::factory()->create();

        Sanctum::actingAs(
            $user = User::factory()->create([
                'current_team_id' => $team->id
            ]),
            ['view-tasks']
        );

        $model = Project::factory()->create([
            'team_id' => $user->current_team_id
        ]);

        $this->get(route('projects.show', [
            'project' => $model->id,
        ]))
            ->assertStatus(200)
            ->assertInertia(fn(Assert $page) => $page
                ->component('Projects/Show'));
    }

    public function test_edit()
    {
        Sanctum::actingAs(
            $user = User::factory()->create(),
            ['view-tasks']
        );

        $model = Project::factory()->create();

        $this->get(route('projects.edit', [
            'project' => $model->id,
        ]))
            ->assertStatus(200)
            ->assertInertia(fn(Assert $page) => $page
                ->component('Projects/Edit'));
    }


    public function test_update()
    {
        Sanctum::actingAs(
            $user = User::factory()->create(),
            ['view-tasks']
        );

        $model = Project::factory()->create();

        $this->put(route('projects.update', [
            'project' => $model->id,
        ]), [
            'subject' => 'foobar',
            'message' => 'foobar',
            'active' => 1,
        ])
            ->assertStatus(302)
            ->assertRedirect(route('projects.edit', [
                'project' => $model->id,
            ]));

        $this->assertEquals('foobar', $model->refresh()->subject);
        $this->assertEquals('foobar', $model->refresh()->message);
    }

    public function test_create()
    {
        $team = Team::factory()->create();

        Sanctum::actingAs(
            $user = User::factory()->create([
                'current_team_id' => $team->id
            ]),
            ['view-tasks']
        );

        $this->get(route('projects.create'))
            ->assertStatus(200)
            ->assertInertia(fn(Assert $page) => $page
                ->component('Projects/Create'));
    }

    public function test_store()
    {
        $team = Team::factory()->create();

        Sanctum::actingAs(
            $user = User::factory()->create([
                'current_team_id' => $team->id
            ]),
            ['view-tasks']
        );

        $this->assertDatabaseCount('projects', 0);
        $this->post(route('projects.create'), [
            'name' => 'foobar',
            'active' => 1,
        ])
            ->assertStatus(302);

        $this->assertDatabaseCount('projects', 1);

        $model = Project::first();

        $this->assertNotNull($model->name);
        $this->assertNotNull($model->team_id);
    }
}
