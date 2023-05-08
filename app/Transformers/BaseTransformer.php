<?php

namespace App\Transformers;

use App\Models\Document;
use App\Models\Transformer;

abstract class BaseTransformer
{
    public function __construct(public Document $document)
    {
    }

    abstract public function handle(Transformer $transformer): Document;
}
