<?php

namespace App\ResponseType;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Attributes\WithCast;

class ContentCollection extends \Spatie\LaravelData\Data
{

    public function __construct(
        #[WithCast(ContentsCaster::class)]
        public Contents $contents
    )
    {
    }

}
