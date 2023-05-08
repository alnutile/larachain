<?php

namespace App\Source\Dtos;

use App\Ingress\IngressTypeEnum;
use Spatie\LaravelData\Data;

class SourceToDocumentDto extends Data
{
    public function __construct(
        public mixed $content,
        public mixed $external_id,
        public mixed $source_id
    ) {
    }
}
