<?php

namespace App\Transformers;

use App\Models\Document;

abstract class BaseTransformer
{
    public function __construct(public Document $document)
    {
    }

    abstract public function handle(): Document;
}
