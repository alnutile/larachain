<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use App\Models\Project;
use App\Models\Transformer;
use App\Jobs\ProcessSourceJob;
use Illuminate\Support\Facades\Queue;
use Illuminate\Foundation\Testing\RefreshDatabase;
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
            ->assertRedirect(route('projects.show', [
                'project' => $project->id
            ]));
    }

    public function test_allow_edit_json_transformer()
    {
        $this->markTestSkipped("@TODO there will be a mapping edit soon");
        $user = User::factory()->withPersonalTeam()->create();
        $user = $this->createTeam($user);

        $project = Project::factory()->create([
            'team_id' => $user->current_team_id,
        ]);

        $transformer = Transformer::factory()->create([
            'project_id' => $project->id,
        ]);

        $this->actingAs($user)
            ->get(route('transformers.json_transformer.edit', [
                'project' => $project->id,
                'transformer' => $transformer->id,
            ]))
            ->assertOk();
    }


    public function test_allow_update_json_transformer()
    {
        $this->markTestSkipped("@TODO there will be a mapping edit soon");
        $user = User::factory()->withPersonalTeam()->create();
        $user = $this->createTeam($user);

        $project = Project::factory()->create([
            'team_id' => $user->current_team_id,
        ]);

        $transformer = Transformer::factory()->create([
            'project_id' => $project->id,
        ]);

        $this->actingAs($user)
            ->put(route('sources.json_transformer.update', [
                'project' => $project->id,
                'transformer' => $transformer->id,
            ]), [
                'name' => 'Foo',
                'meta_data' => [
                    'url' => 'https://foo.bar',
                ],
                'description' => 'Bar',
            ])
            ->assertRedirect(route('projects.show', [
                'project' => $project->id,
            ]));

        $this->assertEquals('Foo', $transformer->refresh()->name);
    }


}
