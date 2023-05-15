<?php

namespace App\Generators\ResponseType;

use Facades\App\Generators\ResponseType\TokenReplacer;
use Illuminate\Support\Facades\File;

class EnumTransformer extends BaseTransformer
{
    public function handle(GeneratorRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;

        $enumPath = app_path('ResponseType/ResponseTypeEnum.php');
        $contents = File::get($enumPath);

        $token = "//case TemplateType = 'template_type'";
        $case = "\n    case [RESOURCE_CLASS_NAME] = '[RESOURCE_KEY]';";
        $case = TokenReplacer::handle($generatorRepository, $case);
        $replaceWith = sprintf('%s/%s', $token, $case);

        $contents = str($contents)
            ->replace($token, $replaceWith)
            ->append($case)
            ->toString();

        File::put($enumPath, $contents);
    }
}
