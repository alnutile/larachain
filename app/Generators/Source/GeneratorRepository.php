<?php

namespace App\Generators\Source;

use App\Generators\BaseRepository;
use Facades\App\Generators\ResponseType\ControllerTransformer;
use Facades\App\Generators\ResponseType\EnumTransformer;
use Facades\App\Generators\ResponseType\LarachainConfigTransformer;
use Facades\App\Generators\ResponseType\ResponseTypeClassTransformer;
use Facades\App\Generators\ResponseType\RoutesTransformer;
use Facades\App\Generators\ResponseType\VueTransformer;
use Illuminate\Support\Facades\File;

class GeneratorRepository extends BaseRepository
{


    public function run() : self
    {
//        ControllerTransformer::handle($this);
//        VueTransformer::handle($this);
//        RoutesTransformer::handle($this);
//        EnumTransformer::handle($this);
//        LarachainConfigTransformer::handle($this);
//        ResponseTypeClassTransformer::handle($this);

        return $this;
    }

}
