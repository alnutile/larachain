<?php

namespace App\Source\Types;

use App\Models\Source;

abstract class BaseSourceType
{
    protected Source $source;

    protected array $payload = [];

    public function __construct(
        Source $source, array $payload = [])
    {
        $this->source = $source;
        $this->payload = $payload;
    }

    abstract public function handle();

    protected function getPath($fileName): string
    {
        return sprintf('%d/sources/%d/%s',
            $this->source->project_id, $this->source->id, $fileName);
    }
}
