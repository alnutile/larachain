<?php

namespace App\Generators\Outbound;

use App\Generators\Base;
use App\Generators\BaseRepository;
use App\Generators\VueGenerator;
use Facades\App\Generators\TokenReplacer;
use Illuminate\Support\Facades\File;

class VueOutbound extends VueGenerator
{
    protected string $generatorName = 'Outbound';
    protected string $plural = 's';

}
