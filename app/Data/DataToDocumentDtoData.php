<?php

namespace App\Data;

use App\Ingress\IngressTypeEnum;
use Spatie\LaravelData\Data;

class DataToDocumentDtoData extends Data
{
    public function __construct(
        public string $content,
        public IngressTypeEnum $type,
        public mixed $external_id,
        public mixed $project_id,
        public array $meta_data
    ) {
    }
}
