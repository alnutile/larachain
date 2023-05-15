<?php

namespace App\Generators\ResponseType;

use Facades\App\Generators\ResponseType\TokenReplacer;
use Illuminate\Support\Facades\File;

    class VueTransformer extends BaseTransformer
    {
        public function handle(GeneratorRepository $generatorRepository): void
        {
            $this->generatorRepository = $generatorRepository;
            $this->makeVue();
            $this->makeComponents();
        }

        protected function makeVue()
        {
            $rootPath = base_path(sprintf('resources/js/Pages/%s',
                $this->generatorRepository->getClassName()));
            if (! File::exists($rootPath.'/Components')) {
                File::makeDirectory($rootPath.'/Components', 0755, true, true);
            }

            $files = File::allFiles($this->generatorRepository->getRootPathOrStubs().'Vue/Resource');

            $components = [
                'ResourceForm.vue',
            ];

            /** @var \Symfony\Component\Finder\SplFileInfo $file */
            foreach ($files as $file) {
                $content = File::get($file->getPathname());
                $transformed = TokenReplacer::handle($this->generatorRepository, $content);

                if (in_array($file->getFilename(), $components)) {
                    $destination = sprintf('%s/Components/%s',
                        $rootPath,
                        $file->getFilename()
                    );
                } else {
                    $destination = sprintf('%s/%s',
                        $rootPath,
                        $file->getFilename()
                    );
                }

                $this->generatorRepository->putFile($destination, $transformed);
            }
        }

        protected function makeComponents()
        {
            $rootPath = base_path('resources/js/Components');

            if (! File::exists($rootPath)) {
                File::makeDirectory($rootPath);
            }

            $files = File::allFiles($this->generatorRepository->getRootPathOrStubs().'Vue/Components/');

            /** @var \Symfony\Component\Finder\SplFileInfo $file */
            foreach ($files as $file) {
                File::copy($file->getPathname(), $rootPath.'/'.$file->getFilename());
            }
        }
}
