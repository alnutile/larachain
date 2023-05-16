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
use App\ResponseType\Types\StringRemove;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StringRemoveTest extends TestCase
{
    use RefreshDatabase;

    public function test_response_type()
    {
        $example = 'But don’t humans also have genuinely original ideas?” Come on, read a fantasy book. It’s either a Tolkien clone, or it’s A Song Of Ice And Fire. Tolkien was a professor of Anglo-Saxon language and culture; no secret where he got his inspiration. A Song Of Ice And Fire is just War Of The Roses with dragons. Lannister and Stark are just Lancaster and York, the map of Westeros is just Britain (minus Scotland) with an upside down-Ireland stuck to the bottom of it – wake up, sheeple! Dullards blend Tolkien into a slurry and shape it into another Tolkien-clone. Tolkien-level artistic geniuses blend human experience, history, and the artistic corpus into a slurry and form it into an entirely new genre. Again, the difference is how finely you blend and what spices you add to the slurry.';
        $source = Source::factory()->create();

        $document = Document::factory()->create([
            'source_id' => $source->id,
        ]);

        DocumentChunk::factory()->count(10)->create([
                'document_id' => $document->id,
                'content' => $example,
            ]
        );

        $documents = DocumentChunk::query()
            ->where('content', 'LIKE', $example)->get();

        $message = Message::factory()->create();

        $responseDto = ResponseDto::from([
            'message' => $message,
            'response' => ContentCollection::from([
                'contents' => Content::collection($documents),
            ]),
        ]);

        $responseType = ResponseType::factory()
            ->create([
                'meta_data' => [
                    'string' => [
                        'original',
                        'humans'
                    ]
                ]
            ]);

        $trim = new StringRemove($source->project, $responseDto);

        $results = $trim->handle($responseType);

        $this->assertStringNotContainsString("humans", $results->response->contents->first()->content);
    }

    public function test_gibberish()
    {
        $example = 'But don’t humans also have genuinely original ideas?” Come on, read a fantasy book. It’s either a Tolkien clone, or it’s A Song Of Ice And Fire. Tolkien was a professor of Anglo-Saxon language and culture; no secret where he got his inspiration. A Song Of Ice And Fire is just War Of The Roses with dragons. Lannister and Stark are just Lancaster and York, the map of Westeros is just Britain (minus Scotland) with an upside down-Ireland stuck to the bottom of it – wake up, sheeple! Dullards blend Tolkien into a slurry and shape it into another Tolkien-clone. Tolkien-level artistic geniuses blend human experience, history, and the artistic corpus into a slurry and form it into an entirely new genre. Again, the difference is how finely you blend and what spices you add to the slurry.';
        $source = Source::factory()->create();

        $document = Document::factory()->create([
            'source_id' => $source->id,
        ]);

        DocumentChunk::factory()->count(10)->create([
                'document_id' => $document->id,
                'content' => $example,
            ]
        );

        $documents = DocumentChunk::query()
            ->where('content', 'LIKE', $example)->get();

        $message = Message::factory()->create();

        $responseDto = ResponseDto::from([
            'message' => $message,
            'response' => ContentCollection::from([
                'contents' => Content::collection($documents),
            ]),
        ]);

        $responseType = ResponseType::factory()
            ->create([
                'meta_data' => [
                    'string' => [
                        'original',
                        'humans'
                    ]
                ]
            ]);

        $trim = new StringRemove($source->project, $responseDto);

        $results = $trim->handle($responseType);

        $this->assertStringNotContainsString("humans", $results->response->contents->first()->content);
    }
}
