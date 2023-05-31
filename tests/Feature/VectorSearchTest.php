<?php

namespace Tests\Feature;

use App\Data\Filters;
use App\Models\Document;
use App\Models\DocumentChunk;
use App\Models\Message;
use App\Models\Project;
use App\Models\ResponseType;
use App\Models\Source;
use App\Models\User;
use App\ResponseType\ContentCollection;
use App\ResponseType\ResponseDto;
use App\ResponseType\Types\VectorSearch;
use Tests\TestCase;

class VectorSearchTest extends TestCase
{
    public function test_search_vector()
    {
        $project = Project::factory()->create();

        $source = Source::factory()->create([
            'project_id' => $project->id,
        ]);

        $document = Document::factory([
            'source_id' => $source->id,
        ])->create();

        DocumentChunk::factory()->withEmbedData()->create([
            'document_id' => $document->id,
        ]);

        User::factory()->create();

        $rt = ResponseType::factory()->vectorSearch()->create();

        $message = Message::factory()->withEmbedData()->create();
        $dto = ResponseDto::from([
            'message' => $message,
            'response' => ContentCollection::emptyContent(),
        ]);

        $vector = new VectorSearch($project, $dto);
        $results = $vector->handle($rt);
        $this->assertNotNull($results->response->getFirstContent());
    }

    public function test_search_with_filters()
    {
        $project = Project::factory()->create();

        $nowSource = Source::factory()->create([
            'project_id' => $project->id,
        ]);

        $source = Source::factory()->create([
            'project_id' => $project->id,
        ]);

        $document = Document::factory([
            'source_id' => $source->id,
        ])->create();

        DocumentChunk::factory()->withEmbedData()->create([
            'document_id' => $document->id,
        ]);

        User::factory()->create();

        $rt = ResponseType::factory()->vectorSearch()->create();

        $message = Message::factory()->withEmbedData()->create();
        $dto = ResponseDto::from([
            'message' => $message,
            'response' => ContentCollection::emptyContent(),
            'filters' => Filters::from([
                'sources' => [$nowSource->id],
            ]),
        ]);

        $vector = new VectorSearch($project, $dto);
        $results = $vector->handle($rt);
        $this->assertNull($results->response->getFirstContent());
    }
}
