<?php

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
        });
});

