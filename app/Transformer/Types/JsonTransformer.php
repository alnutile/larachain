<?php

namespace App\Transformer\Types;

use App\Models\Document;
use App\Models\DocumentChunk;
use App\Models\Transformer;
use App\Transformer\BaseTransformer;
use Facades\App\Helpers\DataMapping;
use Ramsey\Uuid\Uuid;

class JsonTransformer extends BaseTransformer
{
    public function handle(Transformer $transformer): Document
    {

        if (str($this->document->guid)->endsWith('.json')) {
            $fileContents = $this->document->content;
            $guid = md5($fileContents);

            if (! DocumentChunk::query()
                ->where('document_id', $this->document->id)
                ->where('guid', $guid)
                ->exists()) {

                if($mappings = data_get($transformer->meta_data, 'mappings')) {
                    $content = json_decode($this->document->content, true);
                    $mapped = DataMapping::map($mappings, $content);
                    $fileContents = json_encode($mapped);
                }

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
