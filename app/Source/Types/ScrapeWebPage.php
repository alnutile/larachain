<?php

namespace App\Source\Types;

use App\Exceptions\SourceMissingRequiredMetaDataException;
use App\Ingress\StatusEnum;
use App\Models\Document;
use App\Source\SourceEnum;
use Illuminate\Support\Facades\Http;

class ScrapeWebPage extends BaseSourceType
{
    public function handle(): Document
    {

        $url = data_get($this->source->meta_data, 'url');

        $fileName = file_name_from_url($url);

        if (! $url) {
            throw new SourceMissingRequiredMetaDataException();
        }

        $fileContents = Http::get($url)->body();

        return Document::where('guid', $fileName)
            ->where('source_id', $this->source->id)
            ->firstOrCreate(
                [
                    'guid' => $fileName,
                    'source_id' => $this->source->id,
                ],
                [
                    'status' => StatusEnum::Complete,
                    'content' => $fileContents,
                    'type' => SourceEnum::ScrapeWebPage,
                ]
            );
    }
}
