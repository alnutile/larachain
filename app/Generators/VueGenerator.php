<?php

namespace App\Generators;

use Facades\App\Generators\TokenReplacer;
use Illuminate\Support\Facades\File;

class VueGenerator extends Base
{
    protected string $generatorName = 'Outbound';

    public function handle(BaseRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;
        $this->makeVue();
    }

    protected function makeVue()
    {
        $rootPath = base_path(sprintf('resources/js/Pages/%s/%s',
            str($this->generatorName)->plural()->toString(),
            $this->generatorRepository->getClassName()));

        File::makeDirectory(sprintf('%s/Partials', $rootPath), 0755, true, true);

        $path = sprintf($this->generatorRepository->getRootPathOrStubs().'Vue/%s/%s',
            str($this->generatorName)->plural()->toString(),
            $this->generatorName);

        $files = File::allFiles($path);

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
