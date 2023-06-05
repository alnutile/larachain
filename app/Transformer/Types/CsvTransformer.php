<?php

namespace App\Transformer\Types;

use App\Models\Document;
use App\Models\DocumentChunk;
use App\Models\Transformer;
use App\Transformer\BaseTransformer;
use League\Csv\Reader;

class CsvTransformer extends BaseTransformer
{
    public function handle(Transformer $transformer): Document
    {

        if (str($this->document->guid)->endsWith('.csv')) {
            $pathWithFileName = $this->getFilePath($transformer, $this->document->guid);
            $reader = Reader::createFromPath($pathWithFileName, 'r');
            $reader->setHeaderOffset(0);
            $records = $reader->getRecords();
            foreach ($records as $offset => $record) {

                $chunkGuid = $offset.'_'.$this->document->guid;
                if (! DocumentChunk::query()
                    ->where('guid', $chunkGuid)
                    ->where('document_id', $this->document->id)
                    ->exists()) {
                    $fileContents = json_encode($record, JSON_PRETTY_PRINT);

                    DocumentChunk::create([
                        'guid' => $chunkGuid,
                        'content' => $fileContents,
                        'document_id' => $this->document->id,
                    ]);
                }
            }

        }

        return $this->document;
    }

    protected function getFilePath(Transformer $transformer, $fileName): string
    {
        return storage_path(
            sprintf('app/projects/%d/sources/%d/%s',
                $transformer->project_id,
                $this->document->source_id,
                $fileName)
        );
    }
}
