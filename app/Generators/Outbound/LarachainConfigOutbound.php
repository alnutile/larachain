<?php

namespace App\Generators\Outbound;

use App\Generators\LarachainConfig;

class LarachainConfigOutbound extends LarachainConfig
{
    protected string $type = 'outbounds';

    protected string $typeCaps = 'Outbound';
}
