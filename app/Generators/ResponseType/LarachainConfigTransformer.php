<?php

namespace App\Generators\ResponseType;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;

class LarachainConfigTransformer extends BaseTransformer
{
    public function handle(GeneratorRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;

        $sourcePath = config_path('larachain.php');
        $config = config('larachain');

        $config['response_types'][$generatorRepository->getKey()] = [
            'name' => $generatorRepository->name,
            'description' => $generatorRepository->description,
            'requires' => [],
            'active' => 1,
        ];

        $template = <<<'EOD'
<?php

return %s;
EOD;

        $config = var_export($config, true);

        $contents = sprintf($template, $config);

        File::put($sourcePath, $contents);
    }


}
