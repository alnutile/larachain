<?php

namespace App\Source\Types;

use App\Ingress\StatusEnum;
use App\Models\Document;

class FileUploadSource extends BaseSourceType
{
    public function handle(): Document
    {
        /**
         * @NOTE
         * The Controller uploaded the file already
         */
        $fileName = $this->source->meta_data['file_name'];

        return Document::where('guid', $fileName)
            ->where('source_id', $this->source->id)
            ->firstOrCreate(
                [
                    'guid' => $fileName,
                    'source_id' => $this->source->id,
                ],
                [
                    'status' => StatusEnum::Complete,
                ]
            );
    }
}
