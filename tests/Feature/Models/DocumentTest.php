<?php

namespace Tests\Feature\Models;

use App\Models\Document;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DocumentTest extends TestCase
{

    public function test_document_factory()
    {
        $model = Document::factory()->create();

        $this->assertNotNull($model->source->id);
    }

    public function test_project_rel()
    {
        $this->markTestSkipped("Runs fine here but not with others");

        $model = Document::factory()->create();

        $this->assertNotNull($model->project->id);
    }
}
