<?php

namespace App\Generators;

use Illuminate\Support\Facades\File;

class LarachainConfig extends Base
{
    protected string $type = 'sources';

    protected string $typeCaps = 'Source';

    public function run(): self
    {
        return $this;
    }

    public function handle(BaseRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;

        $sourcePath = config_path('larachain.php');
        $config = config('larachain');

        $config[$this->type][$generatorRepository->getKey()] = [
            'name' => $generatorRepository->name,
            'description' => $generatorRepository->description,
            'class' => 'App\\'.$this->typeCaps.'\\Types\\'.$generatorRepository->getClassName(),
            'requires' => [],
            'active' => 1,
        ];

        $template = <<<'EOD'
<?php

return %s;
EOD;

        $config = var_export($config, true);

        $contents = sprintf($template, $config);

        File::put($sourcePath, str($contents)->replace(
            [
                'array (',
                ')',
            ], [
                '[',
                ']',
            ]
        )->toString());
    }
}
