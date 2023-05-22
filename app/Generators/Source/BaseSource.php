<?php

namespace App\Generators\Source;

use Illuminate\Support\Facades\File;

abstract class BaseSource
{
    protected GeneratorRepository $generatorRepository;

    abstract public function handle(GeneratorRepository $generatorRepository): void;

    protected function getContents(string $relativePathAndFile): string
    {
        $content = $this->generatorRepository->getRootPathOrStubs().$relativePathAndFile;

        return File::get($content);
    }
}
