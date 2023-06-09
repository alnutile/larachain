<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class DataToDocumentDtoData extends Data
{
    public function __construct(
        public mixed $content,
        public mixed $external_id,
        public mixed $source_id
    ) {
    }
}
