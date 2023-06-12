<?php

use App\Http\Controllers\Outbounds\ChatGptRetrievalOutboundController;
use App\Http\Controllers\ResponseTypes\ChatApiResponseTypeController;
use App\Http\Controllers\Sources\WebHookSourceController;
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

Route::post('/projects/{project}/sources/{source}/webhook',
        [WebHookSourceController::class, 'webhook'])
    ->name('api.sources.webhook');

Route::middleware('auth:sanctum')
    ->get('/outbounds/{outbound}/response_types/{response_type}/chat_api',
    [ChatApiResponseTypeController::class, 'api'])
    ->name('api.outbound.response_types.chat_api');

Route::middleware('auth:sanctum')->controller(ChatGptRetrievalOutboundController::class)->group(
    function () {
        /**
         * @NOTE taking this in a direction were
         * I no longer need the last response type since it just does
         * what the outbound says it does
         *
         * @see https://github.com/openai/chatgpt-retrieval-plugin/tree/main
         */
        Route::post('/upsert', 'upsert')
            ->name('api.outbounds.chat_gpt_retrieval.upsert');
        Route::post('/upsert-file', 'upsertFile')
            ->name('api.outbounds.chat_gpt_retrieval.upsert_file');
        Route::post('/query/{outbound}', 'query')
            ->name('api.outbounds.chat_gpt_retrieval.query');
        Route::delete('/delete', 'query')
            ->name('api.outbounds.chat_gpt_retrieval.delete');
        Route::get('/.well-known/openapi.yaml', 'openApi')
            ->name('api.outbounds.chat_gpt_retrieval.openapi');
    }
);
