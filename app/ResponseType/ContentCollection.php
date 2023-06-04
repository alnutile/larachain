<?php

namespace App\ResponseType;

use Spatie\LaravelData\Attributes\DataCollectionOf;
use Spatie\LaravelData\DataCollection;

class ContentCollection extends \Spatie\LaravelData\Data
{
        public function __construct(
            #[DataCollectionOf(Content::class)]
            public DataCollection $contents,
            public mixed $raw = []
        ) {
        }

        public function getFirstContent(): Content|null
        {
            return $this->contents->first();
        }

        public static function emptyContent()
        {
            return ContentCollection::from([
                'contents' => Content::collection([]),
            ]);
    }
}
