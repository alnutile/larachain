<?php

namespace App\Source\Types;

use App\Models\Document;
use App\Ingress\StatusEnum;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\SourceMissingRequiredMetaDataException;

class WebFile extends BaseSourceType
{
    public function handle(): Document
    {
        $url = data_get($this->source->meta_data, 'url');

        $fileName = str($url)->afterLast('/')->toString();

        if (! $url) {
            throw new SourceMissingRequiredMetaDataException();
        }

        $fileContents = Http::get($url)->body();

        $path = $this->getPath($fileName);

        Storage::disk('projects')
            ->put($path, $fileContents);

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
                ]
            );

    }

    protected function getPath($fileName)
    {
        return sprintf('%d/sources/%d/%s',
        $this->source->project_id, $this->source->id, $fileName);
    }
}
