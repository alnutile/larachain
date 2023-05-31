<?php

namespace App\Generators\Outbound;

use App\Generators\Base;
use App\Generators\BaseRepository;
use Facades\App\Generators\TokenReplacer;
use Illuminate\Support\Facades\File;

class RoutesOutbound extends Base
{
    public function handle(BaseRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;
        $routes = <<<'EOD'

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(\App\Http\Controllers\Outbound\[RESOURCE_CLASS_NAME]OutboundController::class)->group(
    function () {
        Route::get('/projects/{project}/outbounds/[RESOURCE_KEY]/create', 'create')
            ->name('outbounds.[RESOURCE_KEY].create');
        Route::get('/projects/{project}/outbounds/{outbound}/[RESOURCE_KEY]/edit', 'edit')
            ->name('outbounds.[RESOURCE_KEY].edit');
        Route::post('/projects/{project}/outbounds/[RESOURCE_KEY]/store', 'store')
            ->name('outbounds.[RESOURCE_KEY].store');
        Route::put('/projects/{project}/outbounds/{outbound}/[RESOURCE_KEY]/update', 'update')
            ->name('outbounds.[RESOURCE_KEY].update');
        Route::post('/projects/{project}/outbounds/{outbound}/[RESOURCE_KEY]/run', 'run')
            ->name('outbounds.[RESOURCE_KEY].run');
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
