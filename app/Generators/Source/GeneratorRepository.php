<?php

namespace App\Generators\Source;

use App\Generators\BaseRepository;
use Facades\App\Generators\Source\ControllerSource;
use Facades\App\Generators\Source\EnumSource;
use Facades\App\Generators\Source\LarachainConfigSource;
use Facades\App\Generators\Source\RoutesSource;
use Facades\App\Generators\Source\VueSource;
use Facades\App\Generators\Source\SourceClassTransformer;

class GeneratorRepository extends BaseRepository
{
    public function run(): self
    {
        ControllerSource::handle($this);
        VueSource::handle($this);
        RoutesSource::handle($this);
        EnumSource::handle($this);
        LarachainConfigSource::handle($this);
        SourceClassTransformer::handle($this);

        return $this;
    }
}
