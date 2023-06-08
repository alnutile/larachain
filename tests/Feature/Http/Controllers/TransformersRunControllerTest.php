<?php

namespace Tests\Feature\Http\Controllers;

use App\Jobs\RunTransformerJob;
use App\Models\Project;
use App\Models\Source;
use App\Models\Transformer;
use App\Models\User;
use Illuminate\Support\Facades\Bus;
use Tests\TestCase;

class TransformersRunControllerTest extends TestCase
{
    public function test_runs()
    {
        Bus::fake();
        $project = Project::factory()->create();
        $source = Source::factory()->create([
            'project_id' => $project->id,
        ]);
        $transformer1 = Transformer::factory()->create([
            'project_id' => $project->id,
            'order' => 1,
        ]);
        $transformer2 = Transformer::factory()->create([
            'project_id' => $project->id,
            'order' => 2,
        ]);
        $user = User::factory()->create();
        $this->actingAs($user)->post(route('transformers.run', $project));
        Bus::assertChained([
            new RunTransformerJob($transformer1),
            new RunTransformerJob($transformer2),
        ]);
    }
}
