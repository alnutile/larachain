<?php

namespace Tests\Feature\Models;

use App\Models\Project;
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

    public function test_rels()
    {
        $model = Project::factory()->create();
        $this->assertNotNull($model->team->id);
    }
}
