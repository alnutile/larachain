<?php

namespace App\Generators\Source;

use App\Generators\BaseRepository;
use App\Generators\ClassBase;

class SourceClassTransformer extends ClassBase
{
    protected string $generatorName = 'Source';

    protected string $plural = 'es';

    public function handle(BaseRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;

        $this->makeClass();
        $this->makeTest();
    }
}
