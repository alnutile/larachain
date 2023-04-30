<?php

namespace App\Data;

use Spatie\LaravelData\Data;

class DataToDocumentDtoData extends Data
{
    public function __construct(
        public string $content,
        public mixed $external_id,
        public mixed $project_id,
        public array $meta_data
    ) {}
}
