<?php

namespace App\Generators\Transformer;

use App\Generators\BaseRepository;
use Facades\App\Generators\Source\VueSource;
use Facades\App\Generators\Source\EnumSource;
use Facades\App\Generators\Source\RoutesSource;
use Facades\App\Generators\Source\LarachainConfigSource;
use Facades\App\Generators\Source\SourceClassTransformer;
use Facades\App\Generators\Transformer\ControllerTransformerGenerator;

class GeneratorRepository extends BaseRepository
{
    public function run(): self
    {
        ControllerTransformerGenerator::handle($this);
        // VueSource::handle($this);
        // RoutesSource::handle($this);
        // EnumSource::handle($this);
        // LarachainConfigSource::handle($this);
        // SourceClassTransformer::handle($this);

        return $this;
    }
}
