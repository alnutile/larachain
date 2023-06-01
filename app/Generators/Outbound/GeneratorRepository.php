<?php

namespace App\Generators\Outbound;

use App\Generators\BaseRepository;
use Facades\App\Generators\Outbound\ControllerOutboundGenerator;
use Facades\App\Generators\Outbound\EnumOutbound;
use Facades\App\Generators\Outbound\LarachainConfigOutbound;
use Facades\App\Generators\Outbound\OutboundClassGenerator;
use Facades\App\Generators\Outbound\RoutesOutbound;
use Facades\App\Generators\Outbound\VueOutbound;

class GeneratorRepository extends BaseRepository
{
    public function run(): self
    {
        ControllerOutboundGenerator::handle($this);
        VueOutbound::handle($this);
        RoutesOutbound::handle($this);
        EnumOutbound::handle($this);
        LarachainConfigOutbound::handle($this);
        OutboundClassGenerator::handle($this);

        return $this;
    }
}
