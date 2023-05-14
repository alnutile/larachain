<?php
namespace Tests\Feature;

use App\Models\DocumentChunk;
use App\ResponseType\Content;
use App\ResponseType\ContentCollection;
use phpDocumentor\Reflection\Types\Collection;
use Tests\TestCase;

class ContentCollectionTest extends TestCase
{

    public function test_can_deal_with_documents()
    {

        DocumentChunk::factory()->count(4)->create([
            'content' => "Some Content"
        ]);

        $collection = ContentCollection::from([
            'contents' => DocumentChunk::get()
        ]);

         expect($collection->contents)->toBeInstanceOf(\Illuminate\Support\Collection::class);
         expect($collection->contents->first())->toBeInstanceOf(Content::class);
    }

    public function test_converts()
    {
        $content = "Foo bar";
        $contentDto = Content::from([
            'content' => $content
        ]);
        $collection = ContentCollection::from([
            'contents' => $content
        ]);

        expect($collection->contents)->toBeInstanceOf(\Illuminate\Support\Collection::class);
        expect($collection->contents->first())->toBeInstanceOf(Content::class);
    }
}

//
//it("can handle content that is already set", function() {
//    $content = "Foo bar";
//
//
//    $collection = ContentCollection::from([
//        'contents' => collect($content)
//    ]);
//
//    expect($collection->contents)->toBeInstanceOf(\Illuminate\Support\Collection::class);
//});

