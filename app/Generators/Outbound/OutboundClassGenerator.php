<?php

namespace App\Generators\Outbound;

use App\Generators\ClassBase;
use App\Generators\BaseRepository;
use Facades\App\Generators\TokenReplacer;

class OutboundClassGenerator extends ClassBase
{
    protected string $generatorName = 'Outbound';

    public function handle(BaseRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;

        $this->makeClass();
        $this->makeTest();
    }


}
