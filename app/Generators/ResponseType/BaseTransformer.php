<?php

namespace App\Generators\ResponseType;

use Illuminate\Support\Facades\File;

abstract class BaseTransformer
{
    protected GeneratorRepository $generatorRepository;

    abstract public function handle(GeneratorRepository $generatorRepository): void;

    protected function getContents(string $relativePathAndFile): string
    {
        $content = $this->generatorRepository->getRootPathOrStubs().$relativePathAndFile;

        return File::get($content);
    }
}
