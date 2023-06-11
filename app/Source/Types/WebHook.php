<?php

namespace App\Source\Types;

use App\Ingress\StatusEnum;
use App\Models\Document;

class WebHook extends BaseSourceType
{
    public function handle(): Document
    {
        /**
         * @TODO
         * Need to work this through
         */

        return Document::where('guid', 'wip')
            ->where('source_id', $this->source->id)
            ->firstOrCreate(
                [
                    'guid' => 'wip',
                    'source_id' => $this->source->id,
                ],
                [
                    'status' => StatusEnum::Complete,
                ]
            );
    }
}
