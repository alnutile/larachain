<?php

namespace App\Source\Types;

use App\Models\Source;

abstract class BaseSourceType
{
    protected Source $source;

    protected array $payload = [];

    public function __construct(
        Source $source)
    {
        $this->source = $source;
    }

    public function setPayload(array $payload): self
    {
        $this->payload = $payload;

        return $this;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    abstract public function handle();

    protected function getPath($fileName): string
    {
        return sprintf('%d/sources/%d/%s',
            $this->source->project_id, $this->source->id, $fileName);
    }
}
