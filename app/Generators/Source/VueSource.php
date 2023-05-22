<?php

namespace App\Generators\Source;

use Facades\App\Generators\TokenReplacer;
use Illuminate\Support\Facades\File;

class VueSource extends BaseSource
{
    public function handle(GeneratorRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;
        $this->makeVue();
    }

    protected function makeVue()
    {
        $rootPath = base_path(sprintf('resources/js/Pages/Sources/%s',
            $this->generatorRepository->getClassName()));

        File::makeDirectory(sprintf('%s/Partials', $rootPath), 0755, true, true);

        $files = File::allFiles($this->generatorRepository->getRootPathOrStubs().'Vue/Sources/Source');

        /** @var \Symfony\Component\Finder\SplFileInfo $file */
        foreach ($files as $file) {
            $content = File::get($file->getPathname());
            $transformed = TokenReplacer::handle($this->generatorRepository, $content);

            if ($file->getFilename() === 'ResourceForm.vue') {
                $destination = $rootPath.'/Partials/ResourceForm.vue';
            } else {
                $destination = sprintf('%s/%s',
                    $rootPath,
                    $file->getFilename()
                );
            }

            $this->generatorRepository->putFile($destination, $transformed);
        }
    }
}