<?php

namespace App\ResponseType;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\DataCollection;

class ContentCollection extends \Spatie\LaravelData\Data
{

    public function __construct(
        #[DataCollectionOf(Content::class)]
        public DataCollection $contents
    )
    {
    }

    public function getFirstContent() : Content {
        return $this->contents->first();
    }

    public static function emptyContent() {
        return ContentCollection::from([
            'contents' => Content::collection([])
        ]);
}

}
