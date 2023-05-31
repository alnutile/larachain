<?php

namespace App\Generators;

use Facades\App\Generators\TokenReplacer;
use Illuminate\Support\Facades\File;

abstract class ClassBase
{
    protected string $generatorName = 'Outbound';

    protected string $plural = 's';

    protected BaseRepository $generatorRepository;

    public function handle(BaseRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;

        $this->makeClass();
        $this->makeTest();
    }

    protected function getContents(string $relativePathAndFile): string
    {
        $content = $this->generatorRepository->getRootPathOrStubs().$relativePathAndFile;

        return File::get($content);
    }

    protected function makeTest()
    {
        $generatorNameAndPath = sprintf('/Tests/%sTest.php', $this->generatorName);
        $content = $this->getContents($generatorNameAndPath);
        $transformed = TokenReplacer::handle($this->generatorRepository, $content);

        $name = sprintf('%sTest.php', $this->generatorRepository->getClassName());
        $basePath = base_path('tests/Feature/');
        $destination = $basePath.$name;
        $this->generatorRepository->putFile($destination, $transformed);
    }

    protected function makeClass()
    {
        $content = $this->getContents(sprintf('/%s/Stub.php', $this->generatorName));
        $transformed = TokenReplacer::handle($this->generatorRepository, $content);

        $name = sprintf('%s.php', $this->generatorRepository->getClassName());
        $basePath = base_path(sprintf('app/%s/Types/',
            $this->generatorRepository->getClassName(),
        ));
        $destination = $basePath.$name;
        $this->generatorRepository->putFile($destination, $transformed);
    }
}
