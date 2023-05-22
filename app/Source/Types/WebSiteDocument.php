<?php

namespace App\Source\Types;

use App\Exceptions\SourceMissingRequiredMetaDataException;
use App\Ingress\StatusEnum;
use App\Models\Document;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Soundasleep\Html2Text;

class WebSiteDocument extends BaseSourceType
{
    public function handle(): Document
    {
        /**
         * @NOTE This is one example
         * This example will get a file off the web
         * When this runs the handle is called
         * You could pull in your own classes or put your code here
         */
        $url = data_get($this->source->meta_data, 'url');

        $fileName = str($url)->afterLast('/')->toString();

        if (! $url) {
            throw new SourceMissingRequiredMetaDataException();
        }

        $fileContents = Http::get($url)->body();

        $fileContents = Html2Text::convert($fileContents);

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
                ]
            );
    }

    protected function getPath($fileName)
    {
        return sprintf('%d/sources/%d/%s',
        $this->source->project_id, $this->source->id, $fileName);
    }
}
