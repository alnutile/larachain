<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Project;
use App\Models\Transformer;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Inertia\Testing\AssertableInertia as Assert;
use Tests\TestCase;

class JsonTransformersTransformerControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_show_form_for_json_transformer()
    {
        $user = User::factory()->withPersonalTeam()->create();
        $user = $this->createTeam($user);

        $project = Project::factory()->create([
            'team_id' => $user->current_team_id,
        ]);

        $this->actingAs($user)
            ->get(route('transformers.json_transformer.create', [
                'project' => $project->id,
            ]))
            ->assertRedirect(route('transformers.json_transformer.edit',
                [
                    'project' => $project->id,
                    'transformer' => Transformer::first()->id,
                ]));
    }

    public function test_allow_edit_json_transformer()
    {
        $user = User::factory()->withPersonalTeam()->create();
        $user = $this->createTeam($user);

        $project = Project::factory()->create([
            'team_id' => $user->current_team_id,
        ]);

        $transformer = Transformer::factory()->json()->create([
            'project_id' => $project->id,
        ]);

        $this->actingAs($user)
            ->get(route('transformers.json_transformer.edit', [
                'project' => $project->id,
                'transformer' => $transformer->id,
            ]))
            ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
        ->has('transformer'));
    }

    public function test_allow_update_json_transformer()
    {
        $user = User::factory()->withPersonalTeam()->create();
        $user = $this->createTeam($user);

        $project = Project::factory()->create([
            'team_id' => $user->current_team_id,
        ]);

        $transformer = Transformer::factory()->json()->create([
            'project_id' => $project->id,
        ]);

        $this->actingAs($user)
            ->put(route('transformers.json_transformer.update', [
                'project' => $project->id,
                'transformer' => $transformer->id,
            ]), [
                'name' => 'Foo',
                'mappings' => [
                    'foo.bar',
                ],
                'description' => 'Bar',
            ])
            ->assertRedirect(route('projects.show', [
                'project' => $project->id,
            ]));

        $this->assertEquals([
            'foo.bar',
        ], $transformer->refresh()->meta_data['mappings']);
    }
}
