<?php

namespace App\Transformers\Types;

use App\Models\Document;
use App\Models\DocumentChunk;
use App\Models\Transformer;
use App\Transformers\BaseTransformer;
use Soundasleep\Html2Text as Helper;

class Html2Text extends BaseTransformer
{
    public function handle(Transformer $transformer): Document
    {
        $filePath = $this->document->pathToFile();

        if (str($this->document->guid)->endsWith('.html')) {
            $guid = str($filePath)->afterLast('/');
            if (! DocumentChunk::query()
                ->where('document_id', $this->document->id)
                ->where('guid', $guid)
                ->exists()) {
                $fileContents = Helper::convert($this->document->content, [
                    'ignore_errors' => true,
                ]);

                DocumentChunk::create([
                    'guid' => $guid,
                    'content' => $fileContents,
                    'document_id' => $this->document->id,
                ]);
            }
        }

        return $this->document;
    }
}
