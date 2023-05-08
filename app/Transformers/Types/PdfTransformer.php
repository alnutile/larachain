<?php

namespace App\Transformers\Types;

use App\Models\Document;
use App\Transformers\BaseTransformer;

class PdfTransformer extends BaseTransformer
{
    public function handle(): Document
    {
        //find the source
        //get the file
        //get the content out of the file
        //create the document chunks

        return $this->document;
    }
}
