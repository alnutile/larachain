<?php

namespace App\Generators;

use Facades\App\Generators\TokenReplacer;
use Illuminate\Support\Facades\File;

abstract class Base
{
    protected string $generatorName = 'Outbound';

    protected string $plural = 's';

    protected BaseRepository $generatorRepository;

    public function handle(BaseRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;

        $this->makeController();
        $this->makeTest();
    }

    protected function getContents(string $relativePathAndFile): string
    {
        $content = $this->generatorRepository->getRootPathOrStubs().$relativePathAndFile;

        return File::get($content);
    }

    protected function makeTest()
    {
        $generatorNameAndPath = sprintf('/Tests/%sControllerTest.php', $this->generatorName);
        $content = $this->getContents($generatorNameAndPath);
        $transformed = TokenReplacer::handle($this->generatorRepository, $content);
        $name = sprintf('%s%sControllerTest.php',
            $this->generatorRepository->getClassName(),
            $this->generatorName,
        );
        $basePath = base_path('tests/Feature/Http/Controllers/');
        File::makeDirectory($basePath, 0755, true, true);
        $destination = $basePath.$name;
        $this->generatorRepository->putFile($destination, $transformed);
    }

    protected function makeController()
    {
        $generatorNameAndPath = sprintf('Controllers/%sController.php', $this->generatorName);
        $content = $this->getContents($generatorNameAndPath);

        $transformed = TokenReplacer::handle($this->generatorRepository, $content);

        $name = sprintf('%s%sController.php',
            $this->generatorRepository->getClassName(),
            $this->generatorName,
        );
        $destination = base_path(sprintf('app/Http/Controllers/%s%s/%s',
            $this->generatorName,
            $this->plural,
            $name));

        $this->generatorRepository->putFile($destination, $transformed);
    }
}
