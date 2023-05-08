<?php

namespace App\Source\Dtos;

use App\Ingress\IngressTypeEnum;
use Spatie\LaravelData\Data;

class SourceToDocumentDto extends Data
{
    public function __construct(
        public string $content,
        public IngressTypeEnum $type,
        public mixed $external_id,
        public mixed $project_id
    ) {
    }
}
