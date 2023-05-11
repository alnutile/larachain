<?php

use App\Http\Controllers\Sources\WebFileSourceController;
use App\Http\Controllers\Tranformers\EmbedTransformerController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(WebFileSourceController::class)->group(
    function () {
        Route::get('/projects/{project}/sources/web_file/create', 'create')
            ->name('sources.web_file.create');
        Route::get('/projects/{project}/sources/{source}/web_file/edit', 'edit')
            ->name('sources.web_file.edit');
        Route::post('/projects/{project}/sources/web_file/store', 'store')
            ->name('sources.web_file.store');
        Route::put('/projects/{project}/sources/{source}/web_file/update', 'update')
            ->name('sources.web_file.update');
        Route::post('/projects/{project}/sources/{source}/web_file/run', 'run')
            ->name('sources.web_file.run');
    }
);
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(EmbedTransformerController::class)->group(
    function () {
        Route::get('/projects/{project}/transformers/embed_transformer/create', 'create')
            ->name('transformers.embed_transformer.create');
        Route::get('/projects/{project}/transformers/{transformer}/embed_transformer/edit', 'edit')
            ->name('transformers.embed_transformer.edit');
        Route::post('/projects/{project}/transformers/embed_transformer/store', 'store')
            ->name('transformers.embed_transformer.store');
        Route::put('/projects/{project}/transformers/{transformer}/embed_transformer/update', 'update')
            ->name('transformers.embed_transformer.update');
        Route::post('/projects/{project}/transformers/{transformer}/embed_transformer/run', 'run')
            ->name('transformers.embed_transformer.run');
    }
);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');

    Route::controller(\App\Http\Controllers\ProjectController::class)
        ->group(function () {
            Route::get('/projects', 'index')
                ->name('projects.index');
            Route::get('/projects/create', 'create')
                ->name('projects.create');
            Route::post('/projects/create', 'store')
                ->name('projects.store');
            Route::get('/projects/{project}', 'show')
                ->name('projects.show');
            Route::get('/projects/{project}/edit', 'edit')
                ->name('projects.edit');
            Route::put('/projects/{project}', 'update')
                ->name('projects.update');
            Route::post('/projects/{project}/chat', 'chat')
                ->name('projects.chat');
            Route::delete('/projects/{project}/messages', 'deleteMessages')
                ->name('projects.messages.delete');
        });
});
