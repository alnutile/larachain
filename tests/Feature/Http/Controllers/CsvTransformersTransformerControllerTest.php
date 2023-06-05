<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Project;
use App\Models\Transformer;
use App\Models\User;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class CsvTransformersTransformerControllerTest extends TestCase
{
    public function testShowFormForCsvTransformer()
    {
        $user = User::factory()->withPersonalTeam()->create();
        $user = $this->createTeam($user);

        $project = Project::factory()->create([
            'team_id' => $user->current_team_id,
        ]);

        $response = $this->actingAs($user)->get(route('transformers.csv_transformer.create', [
            'project' => $project->id,
        ]));

        $response->assertRedirectToRoute('projects.show', ['project' => $project->id]);
    }

    public function testRunCsvTransformer()
    {
        Queue::fake();

        $user = User::factory()->withPersonalTeam()->create();
        $user = $this->createTeam($user);

        $project = Project::factory()->create([
            'team_id' => $user->current_team_id,
        ]);

        $transformer = Transformer::factory()
            ->csvTransformer()
            ->create([
                'project_id' => $project->id,
            ]);

        $response = $this->actingAs($user)->post(route('transformers.csv_transformer.run', [
            'project' => $project->id,
            'transformer' => $transformer->id,
        ]));

        $response->assertRedirect(route('projects.show', [
            'project' => $project->id,
        ]));
    }
}
