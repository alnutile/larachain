<?php

namespace App\Generators;

use Illuminate\Support\Facades\File;

abstract class Base
{
    protected BaseRepository $generatorRepository;

    abstract public function handle(BaseRepository $generatorRepository): void;

    protected function getContents(string $relativePathAndFile): string
    {
        $content = $this->generatorRepository->getRootPathOrStubs().$relativePathAndFile;

        return File::get($content);
    }
}
