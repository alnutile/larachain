<?php

namespace App\Generators\Outbound;

use App\Generators\Base;
use App\Generators\BaseRepository;
use Facades\App\Generators\TokenReplacer;
use Illuminate\Support\Facades\File;

class ControllerOutboundGenerator extends Base
{
    public function handle(BaseRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;

        $this->makeController();
        $this->makeTest();
    }

    protected function makeTest()
    {
        $content = $this->getContents('/Tests/OutboundControllerTest.php');
        $transformed = TokenReplacer::handle($this->generatorRepository, $content);

        $name = sprintf('%sOutboundControllerTest.php', $this->generatorRepository->getClassName());
        $basePath = base_path('tests/Feature/Http/Controllers/');
        File::makeDirectory($basePath, 0755, true, true);
        $destination = $basePath.$name;
        $this->generatorRepository->putFile($destination, $transformed);
    }

    protected function makeController()
    {
        $content = $this->getContents('Controllers/OutboundController.php');

        $transformed = TokenReplacer::handle($this->generatorRepository, $content);

        $name = sprintf('%sOutboundController.php', $this->generatorRepository->getClassName());
        $destination = base_path('app/Http/Controllers/Outbounds/'.$name);

        $this->generatorRepository->putFile($destination, $transformed);
    }
}
