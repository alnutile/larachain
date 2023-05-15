<?php

namespace App\Generators\ResponseType;

use Facades\App\Generators\ResponseType\TokenReplacer;
use Illuminate\Support\Facades\File;

class RoutesTransformer extends BaseTransformer
{
    public function handle(GeneratorRepository $generatorRepository): void
    {
        $this->generatorRepository = $generatorRepository;
        $routes = <<<EOD

    Route::controller(\App\Http\Controllers\[RESOURCE_PROPER]Controller::class)
        ->group(function () {
            Route::get('/[RESOURCE_PLURAL_KEY]', 'index')->name('[RESOURCE_PLURAL_KEY].index');
            Route::get('/[RESOURCE_PLURAL_KEY]/create', 'create')->name('[RESOURCE_PLURAL_KEY].create');
            Route::post('/[RESOURCE_PLURAL_KEY]/create', 'store')->name('[RESOURCE_PLURAL_KEY].store');
            Route::get('/[RESOURCE_PLURAL_KEY]/{[RESOURCE_SINGULAR_KEY]}', 'show')->name('[RESOURCE_PLURAL_KEY].show');
            Route::get('/[RESOURCE_PLURAL_KEY]/{[RESOURCE_SINGULAR_KEY]}/edit', 'edit')->name('[RESOURCE_PLURAL_KEY].edit');
            Route::put('/[RESOURCE_PLURAL_KEY]/{[RESOURCE_SINGULAR_KEY]}', 'update')->name('[RESOURCE_PLURAL_KEY].update');
        });
EOD;
        $routesTransformed = TokenReplacer::handle($generatorRepository, $routes);
        $routesPath = base_path('routes/web.php');

        $routesOriginal = File::get($routesPath);

        $routesOriginalUpdated = str($routesOriginal)
            ->append($routesTransformed)->toString();

        File::put($routesPath, $routesOriginalUpdated);
    }
}
