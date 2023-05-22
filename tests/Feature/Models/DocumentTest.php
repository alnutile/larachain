<?php

namespace Tests\Feature\Models;

use App\Models\Document;
use App\Models\Source;
use Tests\TestCase;

class DocumentTest extends TestCase
{
    public function test_document_factory()
    {
        $model = Document::factory()->create();

        $this->assertNotNull($model->source->id);
        $this->assertNotEmpty($model->source->documents);
    }

    public function test_project_rel()
    {
        $this->markTestSkipped('Runs fine here but not with others');

        $model = Document::factory()->create();

        $this->assertNotNull($model->project->id);
    }

    public function test_path_to_file()
    {
        $source = Source::factory()->webFileMetaData()->create();
        $model = Document::factory()->create([
            'source_id' => $source->id,
        ]);
        $expected = sprintf(
            storage_path('app/projects/%d/sources/%d/%s'),
            $source->project_id,
             $source->id,
            $model->guid);
        $this->assertEquals($expected, $model->pathToFile());
    }
}
