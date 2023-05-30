<?php

namespace App\Data;

class Filters extends \Spatie\LaravelData\Data
{

    public function __construct(
        public array $sources = []
    )
    {
    }
}
