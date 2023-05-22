<?php

namespace App\Generators\Source;

use App\Generators\BaseRepository;
//use Facades\App\Generators\Source\EnumTransformer;
//use Facades\App\Generators\Source\LarachainConfigTransformer;
//use Facades\App\Generators\Source\ResponseTypeClassTransformer;
use Facades\App\Generators\Source\ControllerSource;
use Facades\App\Generators\Source\RoutesSource;
use Facades\App\Generators\Source\VueSource;

class GeneratorRepository extends BaseRepository
{
    public function run(): self
    {
        ControllerSource::handle($this);
        VueSource::handle($this);
        RoutesSource::handle($this);
//        EnumTransformer::handle($this);
//        LarachainConfigTransformer::handle($this);
//        ResponseTypeClassTransformer::handle($this);

        return $this;
    }
}
