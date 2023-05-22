<?php

namespace App\Generators\Source;

use Facades\App\Generators\TokenReplacer;
use Illuminate\Support\Facades\File;

class EnumSource extends BaseSource
{
    public function handle(GeneratorRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;

        $enumPath = app_path('Source/SourceTypeEnum.php');
        $contents = File::get($enumPath);

        $token = "//case TemplateType = 'template_type'";
        $case = "\n    case [RESOURCE_CLASS_NAME] = '[RESOURCE_KEY]';";
        $case = TokenReplacer::handle($generatorRepository, $case);
        $replaceWith = sprintf('%s %s', $token, $case);

        $contents = str($contents)
            ->replace([$token], [$replaceWith])
            ->toString();

        File::put($enumPath, $contents);
    }
}
