<?php

namespace App\Generators\Transformer;

use Illuminate\Support\Facades\File;
use Facades\App\Generators\TokenReplacer;

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
        $content = $this->getContents('/Tests/TransformerControllerTest.php');
        $transformed = TokenReplacer::handle($this->generatorRepository, $content);

        $name = sprintf('%sTransformerControllerTest.php', $this->generatorRepository->getClassName());
        $basePath = base_path('tests/Feature/Http/Controllers/');
        File::makeDirectory($basePath, 0755, true, true);
        $destination = $basePath.$name;
        $this->generatorRepository->putFile($destination, $transformed);
    }

    protected function makeController()
    {
        $content = $this->getContents('Controllers/TransformerController.php');

        $transformed = TokenReplacer::handle($this->generatorRepository, $content);

        $name = sprintf('%sTransformerController.php', $this->generatorRepository->getClassName());
        $destination = base_path('app/Http/Controllers/Transformers/'.$name);

        $this->generatorRepository->putFile($destination, $transformed);
    }
}
