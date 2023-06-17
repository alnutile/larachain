<?php

namespace App\Transformer\Types;

use App\Models\Document;
use App\Models\DocumentChunk;
use App\Models\Transformer;
use App\Transformer\BaseTransformer;
use Ramsey\Uuid\Uuid;

class JsonTransformer extends BaseTransformer
{
    public function handle(Transformer $transformer): Document
    {

        $config = config('larachain.sources.'.$this->document->source->type->value.'.transformers', null);

        if ($config && in_array('App\\Transformer\\Types\\JsonTransformer', $config)) {
            $fileContents = $this->document->content;
            $guid = md5($fileContents);

            if (! DocumentChunk::query()
                ->where('document_id', $this->document->id)
                ->where('guid', $guid)
                ->exists()) {
                DocumentChunk::create([
                    'guid' => Uuid::uuid4()->toString(),
                    'content' => $fileContents,
                    'document_id' => $this->document->id,
                ]);
            }
        }

        return $this->document;
    }
}
