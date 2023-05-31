<?php

namespace App\Generators\Outbound;

use App\Generators\BaseRepository;
use App\Generators\ClassBase;

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
