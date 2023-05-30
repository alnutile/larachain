<?php

use App\Http\Controllers\ResponseTypes\ChatApiResponseTypeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')
    ->get('/outbounds/{outbound}/response_types/{response_type}/chat_api',
    [ChatApiResponseTypeController::class, 'api'])
    ->name('api.outbound.response_types.chat_api');
