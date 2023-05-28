<?php

namespace App\Generators\Transformer;

use App\Generators\BaseRepository;
use Facades\App\Generators\Transformer\ControllerTransformerGenerator;
use Facades\App\Generators\Transformer\EnumTransformer;
use Facades\App\Generators\Transformer\LarachainConfigTransformer;
use Facades\App\Generators\Transformer\RoutesTransformer;
use Facades\App\Generators\Transformer\TransformerClassGenerator;
use Facades\App\Generators\Transformer\VueTransformer;

class GeneratorRepository extends BaseRepository
{
    public function run(): self
    {
        ControllerTransformerGenerator::handle($this);
        //VueTransformer::handle($this);
        RoutesTransformer::handle($this);
        EnumTransformer::handle($this);
        LarachainConfigTransformer::handle($this);
        TransformerClassGenerator::handle($this);

        return $this;
    }
}
