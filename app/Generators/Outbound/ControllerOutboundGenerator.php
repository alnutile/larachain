<?php

namespace App\Generators\Outbound;

use App\Generators\Base;
use App\Generators\BaseRepository;

class ControllerOutboundGenerator extends Base
{
    protected string $generatorName = 'Outbound';

    public function handle(BaseRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;

        $this->makeController();
        $this->makeTest();
    }
}
