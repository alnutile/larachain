<?php

namespace App\Generators\ResponseType;

use Facades\App\Generators\TokenReplacer;
use Illuminate\Support\Facades\File;

class RoutesTransformer extends BaseTransformer
{
    public function handle(GeneratorRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;
        $routes = <<<EOD

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(\App\Http\Controllers\ResponseTypes\[RESOURCE_CLASS_NAME]ResponseTypeController::class)->group(
    function () {
        Route::get('/outbounds/{outbound}/response_types/[RESOURCE_KEY]/create', 'create')
            ->name('response_types.[RESOURCE_KEY].create');
        Route::get('/outbounds/{outbound}/response_types/{response_type}/[RESOURCE_KEY]/edit', 'edit')
            ->name('response_types.[RESOURCE_KEY].edit');
        Route::post('/outbounds/{outbound}/response_types/[RESOURCE_KEY]/store', 'store')
            ->name('response_types.[RESOURCE_KEY].store');
        Route::put('/outbounds/{outbound}/response_types/{response_type}/[RESOURCE_KEY]/update', 'update')
            ->name('response_types.[RESOURCE_KEY].update');
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
