<?php

namespace App\Generators\ResponseType;

use App\Generators\BaseRepository;
use App\Generators\ClassBase;

class ResponseTypeClassTransformer extends ClassBase
{
    protected string $generatorName = 'ResponseType';

    public function handle(BaseRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;

        $this->makeClass();
        $this->makeTest();
    }
}
