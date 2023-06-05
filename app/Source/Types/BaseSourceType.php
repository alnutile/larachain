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

    protected function getPath($fileName): string
    {
        return sprintf('%d/sources/%d/%s',
            $this->source->project_id, $this->source->id, $fileName);
    }
}
