<?php

namespace App\Transformers\Types;

use App\Models\Document;
use App\Models\Transformer;
use App\Models\DocumentChunk;
use Soundasleep\Html2Text as Helper;
use App\Transformers\BaseTransformer;

class Html2Text extends BaseTransformer
{
    public function handle(Transformer $transformer): Document
    {
        $filePath = $this->document->pathToFile();

        if (str($this->document->guid)->endsWith(".html")) {
            if (! DocumentChunk::query()
            ->where('document_id', $this->document->id)
            ->exists()) {
                $fileContents = Helper::convert($this->document->content, [
                    'ignore_errors' => true,
                ]);

                DocumentChunk::create([
                    'guid' => str($filePath)->afterLast('/'),
                    'content' => $fileContents,
                    'document_id' => $this->document->id,
                ]);
        }
        }

        return $this->document;
    }
}
