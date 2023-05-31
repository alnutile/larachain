<?php

namespace App\Generators\Transformer;

use App\Generators\Base;
use App\Generators\BaseRepository;
use App\Generators\VueGenerator;
use Facades\App\Generators\TokenReplacer;
use Illuminate\Support\Facades\File;

class VueTransformer extends VueGenerator
{
    protected string $generatorName = 'Transformer';
    protected string $plural = 's';
}
