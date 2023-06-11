<?php

namespace Tests\Feature\Models;

use App\Models\Source;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class SourceTest extends TestCase
{
    use RefreshDatabase;

    public function test_source_factory()
    {
        $model = Source::factory()->create();
        $this->assertNotNull($model->meta_data);
    }

    public function test_project_rel()
    {
        $model = Source::factory()->create();
        $this->assertNotNull($model->project->sources()->first()->id);
    }


    public function test_run_source_type()
    {
        Http::fake();
        $source = Source::factory()->webFileMetaData()->create();

        $source->run();
        Http::assertSentCount(1);

    }
}
