<?php

namespace App\Source\Types;

use App\Models\Source;

abstract class BaseSourceType
{

    protected Source $source;

    public function __construct(Source $source)
    {
        $this->source = $source;
    }

    abstract public function handle();
}
