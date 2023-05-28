<?php

namespace App\Transformers\Types;

use App\Models\Document;
use Soundasleep\Html2Text;
use App\Models\Transformer;
use App\Models\DocumentChunk;
use App\Transformers\BaseTransformer;

class [RESOURCE_CLASS_NAME] extends BaseTransformer
{
    public function handle(Transformer $transformer): Document
    {
        $filePath = $this->document->pathToFile();

        if (str($filePath)->endsWith('.html')) {
            
            if (! DocumentChunk::query()
            ->where('document_id', $this->document->id)
            ->exists()) {
                $fileContents = Html2Text::convert($this->document->content, [
                    'ignore_errors' => true,
                ]);
    
                DocumentChunk::create([
                    'guid' => str($filePath)->afterLast("/"),
                    'content' => $fileContents,
                    'document_id' => $this->document->id,
            ]);
        }
        }

        return $this->document;
    }
}
