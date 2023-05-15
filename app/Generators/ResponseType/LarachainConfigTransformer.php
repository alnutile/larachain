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
            'title' => $generatorRepository->name,
            'description' => $generatorRepository->description,
            'icon' => 'MegaphoneIcon',
            'route' => $generatorRepository->getKey(),
            'requires' => [],
            'background' => $this->getColor(),
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

    protected function getColor(): string
    {
        return Arr::random([
            'bg-red-700',
            'bg-indigo-600',
            'bg-green-500',
            'bg-sky-500',
            'bg-slate-800',
        ]);
    }
}
