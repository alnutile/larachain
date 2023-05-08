<?php

namespace Tests\Feature\Models;

use App\Models\Transformer;
use Tests\TestCase;

class TransformerTest extends TestCase
{
    public function test_transformer_factory()
    {
        $model = Transformer::factory()->create();
        $this->assertNotNull($model->project->id);
        $this->assertNotNull($model->project->transformers->first()->id);
    }
}
