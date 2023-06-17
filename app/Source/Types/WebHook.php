<?php

namespace App\Source\Types;

use App\Ingress\StatusEnum;
use App\Models\Document;

class WebHook extends BaseSourceType
{
    public function handle(): Document
    {
        $content = json_encode($this->payload);
        $contentId = md5($content);
        $contentId = $contentId.'.json';

        $document = Document::query()
            ->where('guid', $contentId)
            ->where('source_id', $this->source->id)
            ->firstOr(function () use ($content, $contentId) {
                $document = Document::create(
                    [
                        'guid' => $contentId,
                        'source_id' => $this->source->id,
                        'status' => StatusEnum::Complete,
                        'type' => $this->source->type,
                        'content' => $content,
                        'meta_data' => [
                            'original_payload' => $this->payload,
                        ],
                    ]
                );

                return $document;
            });

        return $document;
    }
}
