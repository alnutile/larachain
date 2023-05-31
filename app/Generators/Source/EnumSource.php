<?php

namespace App\Generators\Source;

use App\Generators\Base;
use App\Generators\BaseRepository;
use Facades\App\Generators\TokenReplacer;
use Illuminate\Support\Facades\File;

class EnumSource extends Base
{
    public function handle(BaseRepository $generatorRepository): void
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
