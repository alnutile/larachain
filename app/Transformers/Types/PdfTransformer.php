<?php

namespace App\Transformers\Types;

use App\Models\Document;
use App\Models\DocumentChunk;
use App\Models\Transformer;
use App\Transformers\BaseTransformer;
use Smalot\PdfParser\Parser;

class PdfTransformer extends BaseTransformer
{
    public function handle(Transformer $transformer): Document
    {
        $filePath = $this->document->pathToFile();

        if(str($filePath)->endsWith(".pdf")) {
            $parser = new Parser();
            $pdf = $parser->parseFile($filePath);
            $pages = $pdf->getPages();

            foreach ($pages as $page_number => $page) {
                $page_number = $page_number + 1;
                if (! DocumentChunk::query()
                    ->whereGuid($page_number)
                    ->where('document_id', $this->document->id)
                    ->exists()) {
                    DocumentChunk::create([
                        'guid' => $page_number,
                        'content' => remove_ascii($page->getText()),
                        'document_id' => $this->document->id,
                    ]);
                }
            }
        }
        return $this->document;
    }
}
