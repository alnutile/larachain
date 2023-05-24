<?php

namespace Tests\Feature\Http\Controllers;

use App\Models\Project;
use App\Models\Source;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SortingControllerTest extends TestCase
{
    public function test_sorting() {
        $user = User::factory()
            ->withPersonalTeam()
            ->create();

        $user->current_team_id = $user->personalTeam()->id;
        $user->save();

        $project = Project::factory()->create([
            'team_id' => $user->current_team_id
        ]);

        $sort1 = Source::factory()->create(
            ['order' => 1, "project_id" => $project->id]
        );

        $sort2 = Source::factory()->create(
            ['order' => 2, "project_id" => $project->id]
        );

        $sort3 = Source::factory()->create(
            ['order' => 3, "project_id" => $project->id]
        );

        $sortables = [
          $sort3->toArray(),
          $sort1->toArray(),
          $sort2->toArray()
        ];

        $sortables[0]['order'] = 1;
        $sortables[1]['order'] = 5;
        $sortables[2]['order'] = 5;

        $this->actingAs($user)->post(
            route("sortable.sort", [
                'project' => $project->id
            ]), [
                'items' => $sortables,
                'model' => \App\Models\Source::class
            ]
        )->assertStatus(200);

        $this->assertEquals(1, $sort3->refresh()->order);
    }
}
