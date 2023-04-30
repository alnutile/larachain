<?php

namespace Tests\Feature\Models;

use App\Models\Document;
use Tests\TestCase;

class DocumentTest extends TestCase
{
    public function test_factory()
    {
        $model = Document::factory()->create();

        $this->assertNotNull($model->project->id);
    }
}
