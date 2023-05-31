<?php

namespace App\Generators\ResponseType;

use App\Generators\BaseRepository;
use App\Generators\VueGenerator;
use Facades\App\Generators\TokenReplacer;
use Illuminate\Support\Facades\File;

class VueTransformer extends VueGenerator
{
    protected string $generatorName = 'ResponseType';
}
