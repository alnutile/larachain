<?php

namespace App\Generators\Transformer;

use Illuminate\Support\Facades\File;
use Facades\App\Generators\TokenReplacer;
use App\Generators\Transformer\BaseTransformer;

class VueTransformer extends BaseTransformer
{
    public function handle(GeneratorRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;
        $this->makeVue();
    }

    protected function makeVue()
    {
        $rootPath = base_path(sprintf('resources/js/Pages/Transformers/%s',
            $this->generatorRepository->getClassName()));

        File::makeDirectory(sprintf('%s/Partials', $rootPath), 0755, true, true);

        $files = File::allFiles($this->generatorRepository->getRootPathOrStubs().'Vue/Transformers/Transformer');

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
