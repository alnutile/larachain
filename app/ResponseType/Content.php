<?php

namespace App\ResponseType;

class Content extends \Spatie\LaravelData\Data
{
    public function __construct(
        public string $content
    ) {
    }
}
