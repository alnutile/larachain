<?php

namespace Tests\Feature\Models;

use App\Models\Transformer;
use App\Transformers\TransformerTypeEnum;
use Tests\TestCase;

class TransformerTest extends TestCase
{
    public function test_transformer_factory()
    {
        $model = Transformer::factory()->create();
        $this->assertNotNull($model->project->id);
        $this->assertNotNull($model->project->transformers->first()->id);
        $this->assertEquals(TransformerTypeEnum::PdfTransformer, $model->type);
    }

    public function test_run() {

    }
}
