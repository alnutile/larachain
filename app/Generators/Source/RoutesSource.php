<?php

namespace App\Generators\Source;

use Facades\App\Generators\TokenReplacer;
use Illuminate\Support\Facades\File;

class RoutesSource extends BaseSource
{
    public function handle(GeneratorRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;
        $routes = <<<'EOD'

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(\App\Http\Controllers\Sources\[RESOURCE_CLASS_NAME]SourceController::class)->group(
    function () {
        Route::get('/projects/{project}/sources/[RESOURCE_KEY]/create', 'create')
            ->name('sources.[RESOURCE_KEY].create');
        Route::get('/projects/{project}/sources/{source}/[RESOURCE_KEY]/edit', 'edit')
            ->name('sources.[RESOURCE_KEY].edit');
        Route::post('/projects/{project}/sources/[RESOURCE_KEY]/store', 'store')
            ->name('sources.[RESOURCE_KEY].store');
        Route::put('/projects/{project}/sources/{source}/[RESOURCE_KEY]/update', 'update')
            ->name('sources.[RESOURCE_KEY].update');
        Route::post('/projects/{project}/sources/{source}/[RESOURCE_KEY]/run', 'run')
            ->name('sources.[RESOURCE_KEY].run');
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
