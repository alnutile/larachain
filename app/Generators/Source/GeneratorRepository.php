<?php

namespace App\Generators\Source;

use App\Generators\BaseRepository;
//use Facades\App\Generators\Source\EnumTransformer;
//use Facades\App\Generators\Source\LarachainConfigTransformer;
//use Facades\App\Generators\Source\ResponseTypeClassTransformer;
use Facades\App\Generators\Source\RoutesTransformer;
use Facades\App\Generators\Source\VueTransformer;
use Facades\App\Generators\Source\ControllerSource;

class GeneratorRepository extends BaseRepository
{
    public function run(): self
    {
        ControllerSource::handle($this);
        VueTransformer::handle($this);
        RoutesTransformer::handle($this);
//        EnumTransformer::handle($this);
//        LarachainConfigTransformer::handle($this);
//        ResponseTypeClassTransformer::handle($this);

        return $this;
    }
}
