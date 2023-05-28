<?php

namespace App\Generators\Transformer;

use Facades\App\Generators\TokenReplacer;

class TransformerClassGenerator extends BaseTransformer
{
    public function handle(GeneratorRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;

        $this->makeClass();
        $this->makeTest();
    }

    protected function makeTest()
    {
        $content = $this->getContents('/Tests/TransformerTest.php');
        $transformed = TokenReplacer::handle($this->generatorRepository, $content);

        $name = sprintf('%sTest.php', $this->generatorRepository->getClassName());
        $basePath = base_path('tests/Feature/');
        $destination = $basePath.$name;
        $this->generatorRepository->putFile($destination, $transformed);
    }

    protected function makeClass()
    {
        $content = $this->getContents('/Transformer/Stub.php');
        $transformed = TokenReplacer::handle($this->generatorRepository, $content);

        $name = sprintf('%s.php', $this->generatorRepository->getClassName());
        $basePath = base_path('app/Transformer/Types/');
        $destination = $basePath.$name;
        $this->generatorRepository->putFile($destination, $transformed);
    }
}
