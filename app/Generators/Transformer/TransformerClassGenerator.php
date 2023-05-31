<?php

namespace App\Generators\Transformer;

use App\Generators\BaseRepository;
use App\Generators\ClassBase;

class TransformerClassGenerator extends ClassBase
{
    protected string $generatorName = 'Transformer';

    public function handle(BaseRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;

        $this->makeClass();
        $this->makeTest();
    }
}
