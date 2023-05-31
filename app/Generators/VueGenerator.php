<?php

namespace App\Generators;

use App\Generators\Base;
use App\Generators\BaseRepository;
use Facades\App\Generators\TokenReplacer;
use Illuminate\Support\Facades\File;

class VueGenerator extends Base
{
    protected string $generatorName = 'Outbound';
    protected string $plural = 's';

    public function handle(BaseRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;
        $this->makeVue();
    }

    protected function makeVue()
    {
        $rootPath = base_path(sprintf('resources/js/Pages/%s%s/%s',
            $this->generatorName,
            $this->plural,
            $this->generatorRepository->getClassName()));

        File::makeDirectory(sprintf('%s/Partials', $rootPath), 0755, true, true);

        $path = sprintf($this->generatorRepository->getRootPathOrStubs().'Vue/%s%s/%s',
        $this->generatorName,
        $this->plural,
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
