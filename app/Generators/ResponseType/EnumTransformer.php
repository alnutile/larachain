<?php

namespace App\Generators\ResponseType;

use Facades\App\Generators\ResponseType\TokenReplacer;
use Illuminate\Support\Facades\File;

class EnumTransformer extends BaseTransformer
{
    public function handle(GeneratorRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;

        $enumPath = app_path('Generators/ResponseType/EnumTransformer.php');
        $contents = File::get($enumPath);

        $case = "case [RESOURCE_CLASS_NAME] = '[RESOURCE_KEY]'";
        $case = TokenReplacer::handle($generatorRepository, $case);

        $contents = str($contents)
            ->before("case ")
            ->prepend($case)
            ->toString();

        File::put($enumPath, $contents);
    }
}
