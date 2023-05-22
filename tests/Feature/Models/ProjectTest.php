<?php

namespace Tests\Feature\Models;

use App\Models\Document;
use App\Models\Project;
use App\Models\Source;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    use RefreshDatabase;

    public function test_factory()
    {
        $model = Project::factory()->create();
        $this->assertNotNull($model->name);
    }

    public function test_rels_to_documents()
    {
        $project = Project::factory()->create();

        $source1 = Source::factory()->has(Document::factory()->count(1))->create([
            'project_id' => $project->id,
        ]);
        $source2 = Source::factory()->has(Document::factory()->count(2))->create([
            'project_id' => $project->id,
        ]);
        $this->assertCount(2, $project->sources);
        $this->assertCount(3, $project->documents);
    }

    public function test_rels()
    {
        $model = Project::factory()->create();
        $this->assertNotNull($model->team->id);
    }
}
