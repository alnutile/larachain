<?php

namespace Tests\Feature\Models;

use App\Models\Transformer;
use App\Transformer\TransformerEnum;
use Tests\Feature\SharedSetupForPdfFile;
use Tests\TestCase;

class TransformerTest extends TestCase
{
    use SharedSetupForPdfFile;

    public function test_transformer_factory()
    {
        $model = Transformer::factory()->json()->create();
        $this->assertNotNull($model->project->id);
        $this->assertNotNull($model->project->transformers->first()->id);
        $this->assertEquals(TransformerEnum::JsonTransformer, $model->type);

        $this->assertEquals(
            [
                'mappings' => [
                    'optional.path.to.store_one',
                    'optional.path.to.store_two',
                ]
            ],
            $model->meta_data
        );
    }

    public function test_runs_transformers()
    {
        $this->webFileDownloadSetup();
        $model = Transformer::factory()->pdfTranformer()->create([
            'project_id' => $this->source->project_id,
        ]);
        $this->assertDatabaseCount('document_chunks', 0);
        $model->run();
        $this->assertDatabaseCount('document_chunks', 10);
    }
}
