<?php

namespace App\Generators\ResponseType;

use App\Generators\LarachainConfig;

class LarachainConfigTransformer extends LarachainConfig
{
    protected string $type = 'response_types';

    protected string $typeCaps = 'ResponseType';
}
