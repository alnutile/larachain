<?php

namespace Tests\Feature;

use App\Models\DocumentChunk;
use App\ResponseType\Content;
use App\ResponseType\ContentCollection;
use Spatie\LaravelData\DataCollection;
use Tests\TestCase;

class ContentCollectionTest extends TestCase
{
    public function test_can_deal_with_documents()
    {

        DocumentChunk::factory()->count(4)->create([
            'content' => 'Some Content',
        ]);

        $collection = ContentCollection::from([
            'contents' => Content::collection(DocumentChunk::get()),
        ]);

        expect($collection->contents)->toBeInstanceOf(DataCollection::class);
        expect($collection->contents->first())->toBeInstanceOf(Content::class);
    }

    public function test_converts()
    {
        $content = 'Foo bar';

        $contentDto = Content::from([
            'content' => $content,
        ]);

        $collection = ContentCollection::from([
            'contents' => Content::collection([$contentDto]),
        ]);

        expect($collection->contents)->toBeInstanceOf(DataCollection::class);
        expect($collection->contents->first())->toBeInstanceOf(Content::class);
    }

    public function test_empty()
    {

        $collection = ContentCollection::emptyContent();

        expect($collection->contents)->toBeInstanceOf(DataCollection::class);
    }
}
