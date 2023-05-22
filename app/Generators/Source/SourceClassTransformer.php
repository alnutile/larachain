<?php

namespace App\Generators\Source;

use Facades\App\Generators\TokenReplacer;

class SourceClassTransformer extends BaseSource
{
    public function handle(GeneratorRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;

        $this->makeClass();
        $this->makeTest();
    }

    protected function makeTest()
    {
        $content = $this->getContents('/Tests/SourceTest.php');
        $transformed = TokenReplacer::handle($this->generatorRepository, $content);

        $name = sprintf('%sTest.php', $this->generatorRepository->getClassName());
        $basePath = base_path('tests/Feature/');
        $destination = $basePath.$name;
        $this->generatorRepository->putFile($destination, $transformed);
    }

    protected function makeClass()
    {
        $content = $this->getContents('/Source/Stub.php');
        $transformed = TokenReplacer::handle($this->generatorRepository, $content);

        $name = sprintf('%s.php', $this->generatorRepository->getClassName());
        $basePath = base_path('app/Source/Types/');
        $destination = $basePath.$name;
        $this->generatorRepository->putFile($destination, $transformed);
    }
}
