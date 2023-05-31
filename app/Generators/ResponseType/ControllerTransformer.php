<?php

namespace App\Generators\ResponseType;

use App\Generators\Base;
use App\Generators\BaseRepository;

class ControllerTransformer extends Base
{
    protected string $generatorName = 'ResponseType';

    public function handle(BaseRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;

        $this->makeController();
        $this->makeTest();
    }
}
