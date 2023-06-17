<?php

namespace Tests\Feature;

use App\Jobs\ProcessSourceTransformers;
use App\Models\Document;
use App\Models\Project;
use App\Models\Source;
use App\Models\Transformer;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class ProcessSourceTransformersTest extends TestCase
{
    public function test_runs_webhook_transformers()
    {
        /**
         * Stop model events which trigger this
         */
        Event::fake();
        $project = Project::factory()->create();

        $source = Source::factory()->webHook()->create([
            'project_id' => $project->id,
        ]);

        Transformer::factory()->json()->create([
            'project_id' => $project->id,
        ]);

        $this->assertDatabaseCount('document_chunks', 0);

        $document = Document::factory()->create([
            'guid' => 'foo.json',
            'source_id' => $source->id,
            'content' => json_encode(['foo' => 'bar']),
        ]);
        $job = new ProcessSourceTransformers($document);
        $job->handle();
        $this->assertDatabaseCount('document_chunks', 1);
    }

    public function test_does_not_run_transformer()
    {
        /**
         * Stop model events which trigger this
         */
        Event::fake();
        $project = Project::factory()->create();

        $source = Source::factory()->fileUpload()->create([
            'project_id' => $project->id,
        ]);

       Transformer::factory()->json()->create([
           'project_id' => $project->id,
       ]);

        $document = Document::factory()->create([
            'source_id' => $source->id,
            'content' => json_encode(['foo' => 'bar']),
        ]);
        $this->assertDatabaseCount('document_chunks', 0);
        $job = new ProcessSourceTransformers($document);
        $job->handle();
        $this->assertDatabaseCount('document_chunks', 0);
    }

    public function test_embed()
    {
        /**
         * Stop model events which trigger this
         */
        Event::fake();
        Bus::fake();
        $project = Project::factory()->create();

        $source = Source::factory()->fileUpload()->create([
            'project_id' => $project->id,
        ]);

        Transformer::factory()->embed()->create([
            'project_id' => $project->id,
        ]);

        $document = Document::factory()->create([
            'source_id' => $source->id,
            'content' => json_encode(['foo' => 'bar']),
        ]);

        $job = new ProcessSourceTransformers($document);
        $job->handle();

        Bus::assertBatchCount(1);
    }
}
