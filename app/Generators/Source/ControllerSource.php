<?php

namespace App\Generators\Source;

use App\Generators\Base;
use App\Generators\BaseRepository;
use Facades\App\Generators\TokenReplacer;
use Illuminate\Support\Facades\File;

class ControllerSource extends Base
{
    protected string $generatorName = 'Source';
    protected string $plural = 'es';

    public function handle(BaseRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;

        $this->makeController();
        $this->makeTest();
    }

}
