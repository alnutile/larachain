<?php

namespace App\Generators\Source;

use App\Generators\LarachainConfig;
use Illuminate\Support\Facades\File;

class LarachainConfigSource extends LarachainConfig
{

    protected string $type = "sources";
    protected string $typeCaps = "Source";


}
