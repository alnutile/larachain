<?php

namespace App\Source\Types;

use App\Data\DataToDocumentDtoData;
use App\Exceptions\SourceMissingRequiredMetaDataException;
use App\Models\Document;
use App\Source\Dtos\SourceToDocumentDto;
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

        $dto = SourceToDocumentDto::from([
            null,
            $fileName,
            $this->source->id
        ]);



    }

    protected function getPath($fileName)
    {
        return sprintf('%d/sources/%d/%s',
        $this->source->project_id, $this->source->id, $fileName);
    }
}
