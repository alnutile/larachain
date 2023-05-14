<?php

namespace App\ResponseType;

class Contents extends \Spatie\LaravelData\Data
{

    /**
     * @param Content[] $contents
     */
    public function __construct(
        public array $contents
    ) {
    }
}
