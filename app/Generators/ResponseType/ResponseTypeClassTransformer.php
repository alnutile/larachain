<?php

namespace App\Generators\ResponseType;

use Facades\App\Generators\TokenReplacer;

class ResponseTypeClassTransformer extends BaseTransformer
{
    public function handle(GeneratorRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;

        $this->makeClass();
        $this->makeTest();
    }

    protected function makeTest()
    {
        $content = $this->getContents('/Tests/ResponseTypeTest.php');
        $transformed = TokenReplacer::handle($this->generatorRepository, $content);

        $name = sprintf('%sTest.php', $this->generatorRepository->getClassName());
        $basePath = base_path('tests/Feature/');
        $destination = $basePath.$name;
        $this->generatorRepository->putFile($destination, $transformed);
    }

    protected function makeClass()
    {
        $content = $this->getContents('/ResponseType/Stub.php');
        $transformed = TokenReplacer::handle($this->generatorRepository, $content);

        $name = sprintf('%s.php', $this->generatorRepository->getClassName());
        $basePath = base_path('app/ResponseType/Types/');
        $destination = $basePath.$name;
        $this->generatorRepository->putFile($destination, $transformed);
    }
}
