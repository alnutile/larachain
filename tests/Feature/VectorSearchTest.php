<?php

namespace Tests\Feature;

use App\Models\DocumentChunk;
use App\Models\Message;
use App\Models\Project;
use App\Models\ResponseType;
use App\Models\User;
use App\ResponseType\ResponseDto;
use App\ResponseType\Types\VectorSearch;
use Tests\TestCase;

class VectorSearchTest extends TestCase
{
    public function test_search_vector()
    {
        $documentChunk = DocumentChunk::factory()->withEmbedData()->create();

        $project = Project::factory()->create();
        $user = User::factory()->create();

        $rt = ResponseType::factory()->vectorSearch()->create();

        $message = Message::factory()->withEmbedData()->create();
        $dto = ResponseDto::from([
            'message' => $message,
            'response' => null,
        ]);

        $vector = new VectorSearch($project, $dto);
        $results = $vector->handle($rt);
        $this->assertNotNull($results->response);
    }
}
