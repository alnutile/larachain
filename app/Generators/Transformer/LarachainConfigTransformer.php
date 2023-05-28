<?php

namespace App\Generators\Transformer;

use App\Generators\LarachainConfig;

class LarachainConfigTransformer extends LarachainConfig
{
    protected string $type = 'tranformers';

    protected string $typeCaps = 'Transformer';
}
