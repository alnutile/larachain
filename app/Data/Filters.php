<?php

namespace App\Data;

class Filters extends \Spatie\LaravelData\Data
{

    public function __construct(
        public array $sources = []
    )
    {
    }

    public function getSources() {
        return $this->sources;
    }
}
