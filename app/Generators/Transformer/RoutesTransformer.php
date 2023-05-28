<?php

namespace App\Generators\Transformer;

use Facades\App\Generators\TokenReplacer;
use Illuminate\Support\Facades\File;

class RoutesTransformer extends BaseTransformer
{
    public function handle(GeneratorRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;
        $routes = <<<'EOD'

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(\App\Http\Controllers\Transformers\[RESOURCE_CLASS_NAME]TransformerController::class)->group(
    function () {
        Route::get('/projects/{project}/transformers/[RESOURCE_KEY]/create', 'create')
            ->name('transformers.[RESOURCE_KEY].create');
        Route::get('/projects/{project}/transformers/{transformer}/[RESOURCE_KEY]/edit', 'edit')
            ->name('transformers.[RESOURCE_KEY].edit');
        Route::post('/projects/{project}/transformers/[RESOURCE_KEY]/store', 'store')
            ->name('transformers.[RESOURCE_KEY].store');
        Route::put('/projects/{project}/transformers/{transformer}/[RESOURCE_KEY]/update', 'update')
            ->name('transformers.[RESOURCE_KEY].update');
        Route::post('/projects/{project}/transformers/{transformer}/[RESOURCE_KEY]/run', 'run')
            ->name('transformers.[RESOURCE_KEY].run');
    }
);
EOD;
        $routesTransformed = TokenReplacer::handle($generatorRepository, $routes);
        $routesPath = base_path('routes/web.php');

        $routesOriginal = File::get($routesPath);

        $routesOriginalUpdated = str($routesOriginal)
            ->append($routesTransformed)->toString();

        File::put($routesPath, $routesOriginalUpdated);
    }
}
