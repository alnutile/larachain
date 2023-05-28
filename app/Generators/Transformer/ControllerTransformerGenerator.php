<?php

namespace App\Generators\Transformer;

use Facades\App\Generators\TokenReplacer;
use Illuminate\Support\Facades\File;

class ControllerTransformerGenerator extends BaseTransformer
{
    public function handle(GeneratorRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;

        $this->makeController();
        $this->makeTest();
    }

    protected function makeTest()
    {
        $content = $this->getContents('/Tests/SourceControllerTest.php');
        $transformed = TokenReplacer::handle($this->generatorRepository, $content);

        $name = sprintf('%sSourceControllerTest.php', $this->generatorRepository->getClassName());
        $basePath = base_path('tests/Feature/Http/Controllers/');
        File::makeDirectory($basePath, 0755, true, true);
        $destination = $basePath.$name;
        $this->generatorRepository->putFile($destination, $transformed);
    }

    protected function makeController()
    {
        $content = $this->getContents('Controllers/SourceController.php');

        $transformed = TokenReplacer::handle($this->generatorRepository, $content);

        $name = sprintf('%sSourceController.php', $this->generatorRepository->getClassName());
        $destination = base_path('app/Http/Controllers/Sources/'.$name);

        $this->generatorRepository->putFile($destination, $transformed);
    }
}
