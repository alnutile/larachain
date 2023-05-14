<?php

namespace App\Outbound;

class Content extends \Spatie\LaravelData\Data
{
    public function __construct(
        public string $content
    ) {
    }
}
