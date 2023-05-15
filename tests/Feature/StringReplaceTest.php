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
use App\ResponseType\Types\StringReplace;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StringReplaceTest extends TestCase
{
    use RefreshDatabase;

    public function test_response_type()
    {
        $example = '........ Foo Bar ..... ... .... Foo Baz';
        $source = Source::factory()->create();

        $document = Document::factory()->create([
            'source_id' => $source->id,
        ]);

        DocumentChunk::factory()->count(3)->create([
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
            ->stringReplace()
            ->create(
                [
                    'meta_data' => [
                        'search' => [
                            '..',
                            ' .',
                        ],
                        'replace' => [
                            '',
                            '',
                        ],
                    ],
                ]
            );

        $trim = new StringReplace($source->project, $responseDto);

        $results = $trim->handle($responseType);

        $this->assertInstanceOf(ResponseDto::class, $results);

        $this->assertEquals(' Foo Bar  Foo Baz', $results->response->contents->first()->content);
    }
}
