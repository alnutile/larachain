<?php

namespace App\Generators\ResponseType;

use App\Generators\LarachainConfig;
use Illuminate\Support\Facades\File;

class LarachainConfigTransformer extends LarachainConfig
{
    protected string $type = "response_types";
    protected string $typeCaps = "ResponseType";

}
