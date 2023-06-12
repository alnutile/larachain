<?php

namespace App\Transformer\Types;

use App\Models\Document;
use App\Models\DocumentChunk;
use App\Models\Transformer;
use App\Transformer\BaseTransformer;
use Soundasleep\Html2Text as Helper;

class Html2Text extends BaseTransformer
{
    public function handle(Transformer $transformer): Document
    {
        $filePath = $this->document->pathToFile();

        if (str($this->document->guid)->endsWith('.html')) {
            $guid = str($filePath)->afterLast('/');

            $text = Helper::convert($this->document->content, [
                'ignore_errors' => true,
            ]);
            $textUnicodeRemoved = preg_replace('/[^\x20-\x7E]/u', '', $text);
            if (! DocumentChunk::query()
                ->where('document_id', $this->document->id)
                ->where('guid', $guid)
                ->exists()) {
                DocumentChunk::create([
                    'guid' => $guid,
                    'content' => $textUnicodeRemoved,
                    'document_id' => $this->document->id,
                ]);
            }
        }

        return $this->document;
    }
}
