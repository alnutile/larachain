<?php

namespace App\Source\Types;

use App\Exceptions\SourceMissingRequiredMetaDataException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class WebFile extends BaseSourceType
{
    public function handle()
    {
        $url = data_get($this->source->meta_data, 'url');

        $fileName = str($url)->afterLast('/');

        if (! $url) {
            throw new SourceMissingRequiredMetaDataException();
        }

        $fileContents = Http::get($url)->body();

        Storage::disk('projects')->put($this->getPath($fileName), $fileContents);

        return true;

    }

    protected function getPath($fileName)
    {
        return sprintf('%d/sources/%d/%s',
        $this->source->project_id, $this->source->id, $fileName);
    }
}
