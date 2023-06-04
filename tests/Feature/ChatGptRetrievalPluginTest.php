<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\DocumentChunk;
use App\Models\Message;
use App\Models\ResponseType;
use App\Models\Source;
use App\ResponseType\Content;
use App\ResponseType\ContentCollection;
use App\ResponseType\ResponseDto;
use App\ResponseType\Types\ChatGptRetrievalPlugin;
use App\ResponseType\Types\VectorSearch;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChatGptRetrievalPluginTest extends TestCase
{
    use RefreshDatabase;

    public function test_response_type()
    {
        $example = 'But don’t humans also have genuinely original ideas?” Come on, read a fantasy book. It’s either a Tolkien clone, or it’s A Song Of Ice And Fire. Tolkien was a professor of Anglo-Saxon language and culture; no secret where he got his inspiration. A Song Of Ice And Fire is just War Of The Roses with dragons. Lannister and Stark are just Lancaster and York, the map of Westeros is just Britain (minus Scotland) with an upside down-Ireland stuck to the bottom of it – wake up, sheeple! Dullards blend Tolkien into a slurry and shape it into another Tolkien-clone. Tolkien-level artistic geniuses blend human experience, history, and the artistic corpus into a slurry and form it into an entirely new genre. Again, the difference is how finely you blend and what spices you add to the slurry.';
        $source = Source::factory()->create();

        $document = Document::factory()->create([
            'source_id' => $source->id,
        ]);

        DocumentChunk::factory()->withEmbedData()->create([
            'document_id' => $document->id,
        ]);

        $rt = ResponseType::factory()->vectorSearch()->create();

        $message = Message::factory()->withEmbedData()->create();

        $dto = ResponseDto::from([
            'message' => $message,
            'response' => ContentCollection::emptyContent(),
        ]);

        $vector = new VectorSearch($source->project, $dto);
        $responseDto = $vector->handle($rt);

        $chatGtpRt = ResponseType::factory()->chatGtpRetrieval()->create();

        $results = new ChatGptRetrievalPlugin($source->project, $responseDto);
        $responseDto = $results->handle($chatGtpRt);
        $first = $responseDto->response->raw->first();

        $this->assertNotEmpty($first);
        $this->assertArrayHasKey('distance', $first);
        $this->assertArrayHasKey('content', $first);
        $this->assertArrayHasKey('embedding', $first);
        $this->assertArrayHasKey('id', $first);
    }
}
