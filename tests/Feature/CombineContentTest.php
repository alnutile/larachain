<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\DocumentChunk;
use App\Models\Message;
use App\Models\Project;
use App\Models\ResponseType;
use App\Models\Source;
use App\ResponseType\Content;
use App\ResponseType\ContentCollection;
use App\ResponseType\ResponseDto;
use App\ResponseType\Types\CombineContent;
use App\ResponseType\Types\TrimText;
use Tests\TestCase;

class CombineContentTest extends TestCase {

    public function test_combines_and_returns() {
        $source = Source::factory()->create();

        $document = Document::factory()->create([
            'source_id' => $source->id,
        ]);
        DocumentChunk::factory()->count(10)->create([
                'document_id' => $document->id,
            ]
        );

        $documents = DocumentChunk::query()
            ->join('documents', 'documents.id', '=', 'document_chunks.document_id')
            ->join('sources', 'sources.id', '=', 'documents.source_id')
            ->get();

        $message = Message::factory()->create();

        $responseDto = ResponseDto::from([
            'message' => $message,
            'response' => ContentCollection::from([
                'contents' => Content::collection($documents)
            ]),
        ]);

        $responseType = ResponseType::factory()->create();

        $combine = new CombineContent($source->project, $responseDto);

        $results = $combine->handle($responseType);

        expect($results->response)->not->toBeNull();
    }
}
