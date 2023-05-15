<?php

namespace App\Generators\ResponseType;

use Facades\App\Generators\ResponseType\TokenReplacer;

class ControllerTransformer extends BaseTransformer
{
    public function handle(GeneratorRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;

        $this->makeController();
        $this->makeTest();
    }

    protected function makeTest()
    {
        $content = $this->getContents('/Tests/ResourceControllerTest.php');
        $tranformed = TokenReplacer::handle($this->generatorRepository, $content);

        $name = sprintf('%sControllerTest.php', $this->generatorRepository->getClassName());
        $destination = base_path('tests/Feature/Http/Controllers/'.$name);

        $this->generatorRepository->putFile($destination, $tranformed);
    }

    protected function makeController()
    {
        $content = $this->getContents('Controllers/ResponseTypeController.php');

        $transformed = TokenReplacer::handle($this->generatorRepository, $content);

        $name = sprintf('%sResponseTypeController.php', $this->generatorRepository->getClassName());
        $destination = base_path('app/Http/Controllers/'.$name);

        $this->generatorRepository->putFile($destination, $transformed);
    }
}
