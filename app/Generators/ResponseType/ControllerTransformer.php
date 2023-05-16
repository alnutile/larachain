<?php

namespace App\Generators\ResponseType;

use Facades\App\Generators\ResponseType\TokenReplacer;
use Illuminate\Support\Facades\File;

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
        if ($this->generatorRepository->getRequiresSettings()) {
            $content = $this->getContents('/Tests/ResponseTypeWithSettingsControllerTest.php');
        } else {
            $content = $this->getContents('/Tests/ResponseTypeControllerTest.php');
        }

        $transformed = TokenReplacer::handle($this->generatorRepository, $content);

        $name = sprintf('%sResponseTypeControllerTest.php', $this->generatorRepository->getClassName());
        $basePath = base_path('tests/Feature/Http/Controllers/');
        File::makeDirectory($basePath, 0755, true, true);
        $destination = $basePath.$name;
        $this->generatorRepository->putFile($destination, $transformed);
    }

    protected function makeController()
    {
        if ($this->generatorRepository->getRequiresSettings()) {
            $content = $this->getContents('Controllers/ResponseTypeWithSettingsController.php');
        } else {
            $content = $this->getContents('Controllers/ResponseTypeController.php');
        }

        $transformed = TokenReplacer::handle($this->generatorRepository, $content);

        $name = sprintf('%sResponseTypeController.php', $this->generatorRepository->getClassName());
        $destination = base_path('app/Http/Controllers/ResponseTypes/'.$name);

        $this->generatorRepository->putFile($destination, $transformed);
    }
}
