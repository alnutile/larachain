<?php

namespace App\Source\Types;

use App\Ingress\StatusEnum;
use App\Jobs\ProcessSourceListeners;
use App\Models\Document;
use Ramsey\Uuid\Uuid;

class WebHook extends BaseSourceType
{
    public function handle(): Document
    {
        $document = Document::create(
                [
                    'guid' => Uuid::uuid4()->toString(),
                    'source_id' => $this->source->id,
                    'status' => StatusEnum::Complete,
                    'type' => $this->source->type->value,
                    'content' => json_encode($this->payload),
                    'meta_data' => [
                        'original_payload' => $this->payload,
                    ],
                ]
            );

        ProcessSourceListeners::dispatch($document);

        return $document;
    }
}
