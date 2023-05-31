<?php

namespace App\Generators\Transformer;

use App\Generators\Base;
use App\Generators\BaseRepository;
use Facades\App\Generators\TokenReplacer;
use Illuminate\Support\Facades\File;

class ControllerTransformerGenerator extends Base
{
    protected string $generatorName = 'Transformer';

    public function handle(BaseRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;

        $this->makeController();
        $this->makeTest();
    }

}
