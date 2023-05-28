<?php

namespace App\Generators\Transformer;

use App\Generators\BaseRepository;
use Facades\App\Generators\Transformer\VueTransformer;
use Facades\App\Generators\Transformer\EnumTransformer;
use Facades\App\Generators\Transformer\RoutesTransformer;
// use Facades\App\Generators\Transformer\LarachainConfigTransformer;
// use Facades\App\Generators\Transformer\SourceClassTransformer;
use Facades\App\Generators\Transformer\ControllerTransformerGenerator;

class GeneratorRepository extends BaseRepository
{
    public function run(): self
    {
        ControllerTransformerGenerator::handle($this);
        VueTransformer::handle($this);
        RoutesTransformer::handle($this);
        EnumTransformer::handle($this);
        // LarachainConfigSource::handle($this);
        // SourceClassTransformer::handle($this);

        return $this;
    }
}
