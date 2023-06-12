<?php

use App\Http\Controllers\CloneResponseTypesController;
use App\Http\Controllers\Outbounds\ApiOutboundController;
use App\Http\Controllers\Outbounds\ChatUiOutboundController;
use App\Http\Controllers\ResponseTypes\ChatUiResponseTypeController;
use App\Http\Controllers\ResponseTypes\CombineContentResponseTypeController;
use App\Http\Controllers\ResponseTypes\EmbedQuestionResponseTypeController;
use App\Http\Controllers\ResponseTypes\TrimTextResponseTypeController;
use App\Http\Controllers\ResponseTypes\VectorSearchResponseTypeController;
use App\Http\Controllers\SortingController;
use App\Http\Controllers\Sources\ScrapeWebPageSourceController;
use App\Http\Controllers\Sources\WebFileSourceController;
use App\Http\Controllers\Transformers\EmbedTransformerController;
use App\Http\Controllers\Transformers\PdfTransformerController;
use App\Http\Controllers\TransformersRunController;
use App\Models\Project;
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
})->name('home');

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
])->controller(PdfTransformerController::class)->group(
    function () {
        Route::get('/projects/{project}/transformers/pdf_transformer/create', 'create')
            ->name('transformers.pdf_transformer.create');
        Route::get('/projects/{project}/transformers/{transformer}/pdf_transformer/edit', 'edit')
            ->name('transformers.pdf_transformer.edit');
        Route::post('/projects/{project}/transformers/pdf_transformer/store', 'store')
            ->name('transformers.pdf_transformer.store');
        Route::put('/projects/{project}/transformers/{transformer}/pdf_transformer/update', 'update')
            ->name('transformers.pdf_transformer.update');
        Route::post('/projects/{project}/transformers/{transformer}/pdf_transformer/run', 'run')
            ->name('transformers.pdf_transformer.run');
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
])->controller(TransformersRunController::class)->group(
    function () {
        Route::post('/projects/{project}/transformers/run', 'run')
            ->name('transformers.run');
    }
);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(ApiOutboundController::class)->group(
    function () {
        Route::get('/projects/{project}/outbounds/api/create', 'create')
            ->name('outbounds.api.create');
        Route::get('/projects/{project}/outbounds/{outbound}/api', 'show')
            ->name('outbounds.api.show');
        Route::get('/projects/{project}/outbounds/{outbound}/api/edit', 'edit')
            ->name('outbounds.api.edit');
        Route::post('/projects/{project}/outbounds/api/store', 'store')
            ->name('outbounds.api.store');
        Route::put('/projects/{project}/outbounds/{outbound}/api/update', 'update')
            ->name('outbounds.api.update');
        Route::post('/projects/{project}/outbounds/{outbound}/api/run', 'run')
            ->name('outbounds.api.run');
    }
);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(ChatUiOutboundController::class)->group(
    function () {
        Route::get('/projects/{project}/outbounds/chat_ui/create', 'create')
            ->name('outbounds.chat_ui.create');
        Route::get('/projects/{project}/outbounds/{outbound}/chat_ui', 'show')
            ->name('outbounds.chat_ui.show');
        Route::get('/projects/{project}/outbounds/{outbound}/chat_ui/edit', 'edit')
            ->name('outbounds.chat_ui.edit');
        Route::post('/projects/{project}/outbounds/chat_ui/store', 'store')
            ->name('outbounds.chat_ui.store');
        Route::put('/projects/{project}/transformers/{outbound}/chat_ui/update', 'update')
            ->name('outbounds.chat_ui.update');
        Route::post('/projects/{project}/transformers/{outbound}/chat_ui/run', 'run')
            ->name('outbounds.chat_ui.run');
    }
);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
   Route::get('/projects/{project}/outbounds', function (Project $project) {
       return response($project->outbounds);
   })->name('projects.outbounds');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(CombineContentResponseTypeController::class)->group(
    function () {
        Route::get('/outbounds/{outbound}/response_types/combine_content/create', 'create')
            ->name('response_types.combine_content.create');
        Route::get('/outbounds/{outbound}/response_types/{response_type}/combine_content/edit', 'edit')
            ->name('response_types.combine_content.edit');
        Route::post('/outbounds/{outbound}/response_types/combine_content/store', 'store')
            ->name('response_types.combine_content.store');
        Route::put('/outbounds/{outbound}/response_types/{response_type}/combine_content/update', 'update')
            ->name('response_types.combine_content.update');
    }
);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(TrimTextResponseTypeController::class)->group(
    function () {
        Route::get('/outbounds/{outbound}/response_types/trim_text/create', 'create')
            ->name('response_types.trim_text.create');
        Route::get('/outbounds/{outbound}/response_types/{response_type}/trim_text/edit', 'edit')
            ->name('response_types.trim_text.edit');
        Route::post('/outbounds/{outbound}/response_types/trim_text/store', 'store')
            ->name('response_types.trim_text.store');
        Route::put('/outbounds/{outbound}/response_types/{response_type}/trim_text/update', 'update')
            ->name('response_types.trim_text.update');
    }
);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(EmbedQuestionResponseTypeController::class)->group(
    function () {
        Route::get('/outbounds/{outbound}/response_types/embed_question/create', 'create')
            ->name('response_types.embed_question.create');
        Route::get('/outbounds/{outbound}/response_types/{response_type}/embed_question/edit', 'edit')
            ->name('response_types.embed_question.edit');
        Route::post('/outbounds/{outbound}/response_types/embed_question/store', 'store')
            ->name('response_types.embed_question.store');
        Route::put('/outbounds/{outbound}/response_types/{response_type}/embed_question/update', 'update')
            ->name('response_types.embed_question.update');
    }
);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(VectorSearchResponseTypeController::class)->group(
    function () {
        Route::get('/outbounds/{outbound}/response_types/vector_search/create', 'create')
            ->name('response_types.vector_search.create');
        Route::get('/outbounds/{outbound}/response_types/{response_type}/vector_search/edit', 'edit')
            ->name('response_types.vector_search.edit');
        Route::post('/outbounds/{outbound}/response_types/vector_search/store', 'store')
            ->name('response_types.vector_search.store');
        Route::put('/outbounds/{outbound}/response_types/{response_type}/vector_search/update', 'update')
            ->name('response_types.vector_search.update');
    }
);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(ChatUiResponseTypeController::class)->group(
    function () {
        Route::get('/outbounds/{outbound}/response_types/chat_ui/create', 'create')
            ->name('response_types.chat_ui.create');
        Route::get('/outbounds/{outbound}/response_types/{response_type}/chat_ui/edit', 'edit')
            ->name('response_types.chat_ui.edit');
        Route::post('/outbounds/{outbound}/response_types/chat_ui/store', 'store')
            ->name('response_types.chat_ui.store');
        Route::put('/outbounds/{outbound}/response_types/{response_type}/chat_ui/update', 'update')
            ->name('response_types.chat_ui.update');
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

    Route::post('/sortable/{project}/sort',
        SortingController::class)
        ->name('sortable.sort');

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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(\App\Http\Controllers\ResponseTypes\StringReplaceResponseTypeController::class)->group(
    function () {
        Route::get('/outbounds/{outbound}/response_types/string_replace/create', 'create')
            ->name('response_types.string_replace.create');
        Route::get('/outbounds/{outbound}/response_types/{response_type}/string_replace/edit', 'edit')
            ->name('response_types.string_replace.edit');
        Route::post('/outbounds/{outbound}/response_types/string_replace/store', 'store')
            ->name('response_types.string_replace.store');
        Route::put('/outbounds/{outbound}/response_types/{response_type}/string_replace/update', 'update')
            ->name('response_types.string_replace.update');
    }
);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(\App\Http\Controllers\ResponseTypes\StringRemoveResponseTypeController::class)->group(
    function () {
        Route::get('/outbounds/{outbound}/response_types/string_remove/create', 'create')
            ->name('response_types.string_remove.create');
        Route::get('/outbounds/{outbound}/response_types/{response_type}/string_remove/edit', 'edit')
            ->name('response_types.string_remove.edit');
        Route::post('/outbounds/{outbound}/response_types/string_remove/store', 'store')
            ->name('response_types.string_remove.store');
        Route::put('/outbounds/{outbound}/response_types/{response_type}/string_remove/update', 'update')
            ->name('response_types.string_remove.update');
    }
);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(\App\Http\Controllers\ResponseTypes\PregReplaceResponseTypeController::class)->group(
    function () {
        Route::get('/outbounds/{outbound}/response_types/preg_replace/create', 'create')
            ->name('response_types.preg_replace.create');
        Route::get('/outbounds/{outbound}/response_types/{response_type}/preg_replace/edit', 'edit')
            ->name('response_types.preg_replace.edit');
        Route::post('/outbounds/{outbound}/response_types/preg_replace/store', 'store')
            ->name('response_types.preg_replace.store');
        Route::put('/outbounds/{outbound}/response_types/{response_type}/preg_replace/update', 'update')
            ->name('response_types.preg_replace.update');
    }
);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(ScrapeWebPageSourceController::class)->group(
    function () {
        Route::get('/projects/{project}/sources/scrape_web_page/create', 'create')
            ->name('sources.scrape_web_page.create');
        Route::get('/projects/{project}/sources/{source}/scrape_web_page/edit', 'edit')
            ->name('sources.scrape_web_page.edit');
        Route::post('/projects/{project}/sources/scrape_web_page/store', 'store')
            ->name('sources.scrape_web_page.store');
        Route::put('/projects/{project}/sources/{source}/scrape_web_page/update', 'update')
            ->name('sources.scrape_web_page.update');
        Route::post('/projects/{project}/sources/{source}/scrape_web_page/run', 'run')
            ->name('sources.scrape_web_page.run');
    }
);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(\App\Http\Controllers\DeleteSourceController::class)->group(
    function () {
        Route::delete('/sources/{source}/delete', 'delete')
            ->name('sources.delete');
    }
);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(\App\Http\Controllers\DeleteTransformerController::class)->group(
    function () {
        Route::delete('/transformers/{transformer}/delete', 'delete')
            ->name('transformers.delete');
    }
);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(\App\Http\Controllers\DeleteOutboundController::class)->group(
    function () {
        Route::delete('/outbounds/{outbound}/delete', 'delete')
            ->name('outbounds.delete');
    }
);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(\App\Http\Controllers\DeleteResponseTypesController::class)->group(
    function () {
        Route::delete('/response_types/{response_type}/delete', 'delete')
            ->name('response_types.delete');
    }
);

Route::post('/outbounds/clone', CloneResponseTypesController::class)
    ->name('outbounds.clone.response_types')
    ->middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ]);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(\App\Http\Controllers\Transformers\Html2TextTransformerController::class)->group(
    function () {
        Route::get('/projects/{project}/transformers/html2text/create', 'create')
            ->name('transformers.html2text.create');
        Route::get('/projects/{project}/transformers/{transformer}/html2text/edit', 'edit')
            ->name('transformers.html2text.edit');
        Route::post('/projects/{project}/transformers/html2text/store', 'store')
            ->name('transformers.html2text.store');
        Route::put('/projects/{project}/transformers/{transformer}/html2text/update', 'update')
            ->name('transformers.html2text.update');
        Route::post('/projects/{project}/transformers/{transformer}/html2text/run', 'run')
            ->name('transformers.html2text.run');
    }
);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(\App\Http\Controllers\ResponseTypes\ChatApiResponseTypeController::class)->group(
    function () {
        Route::get('/outbounds/{outbound}/response_types/chatapi/create', 'create')
            ->name('response_types.chatapi.create');
        Route::get('/outbounds/{outbound}/response_types/{response_type}/chatapi/edit', 'edit')
            ->name('response_types.chatapi.edit');
        Route::post('/outbounds/{outbound}/response_types/chatapi/store', 'store')
            ->name('response_types.chatapi.store');
        Route::put('/outbounds/{outbound}/response_types/{response_type}/chatapi/update', 'update')
            ->name('response_types.chatapi.update');
    }
);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(\App\Http\Controllers\Outbounds\ChatGptRetrievalOutboundController::class)->group(
    function () {
        Route::get('/projects/{project}/outbounds/chat_gpt_retrieval/create', 'create')
            ->name('outbounds.chat_gpt_retrieval.create');
        Route::get('/projects/{project}/outbounds/{outbound}/chat_gpt_retrieval/edit', 'edit')
            ->name('outbounds.chat_gpt_retrieval.edit');
        Route::get('/projects/{project}/outbounds/{outbound}/chat_gpt_retrieval', 'show')
            ->name('outbounds.chat_gpt_retrieval.show');
        Route::post('/projects/{project}/outbounds/chat_gpt_retrieval/store', 'store')
            ->name('outbounds.chat_gpt_retrieval.store');
        Route::put('/projects/{project}/outbounds/{outbound}/chat_gpt_retrieval/update', 'update')
            ->name('outbounds.chat_gpt_retrieval.update');
        Route::post('/projects/{project}/outbounds/{outbound}/chat_gpt_retrieval/run', 'run')
            ->name('outbounds.chat_gpt_retrieval.run');
    }
);
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(\App\Http\Controllers\ResponseTypes\ChatGptRetrievalResponseTypeController::class)->group(
    function () {
        Route::get('/outbounds/{outbound}/response_types/chat_gpt_retrieval/create', 'create')
            ->name('response_types.chat_gpt_retrieval.create');
        Route::get('/outbounds/{outbound}/response_types/{response_type}/chat_gpt_retrieval/edit', 'edit')
            ->name('response_types.chat_gpt_retrieval.edit');
        Route::post('/outbounds/{outbound}/response_types/chat_gpt_retrieval/store', 'store')
            ->name('response_types.chat_gpt_retrieval.store');
        Route::put('/outbounds/{outbound}/response_types/{response_type}/chat_gpt_retrieval/update', 'update')
            ->name('response_types.chat_gpt_retrieval.update');
    }
);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(\App\Http\Controllers\Sources\FileUploadSourceSourceController::class)->group(
    function () {
        Route::get('/projects/{project}/sources/file_upload_source/create', 'create')
            ->name('sources.file_upload_source.create');
        Route::get('/projects/{project}/sources/{source}/file_upload_source/edit', 'edit')
            ->name('sources.file_upload_source.edit');
        Route::post('/projects/{project}/sources/file_upload_source/store', 'store')
            ->name('sources.file_upload_source.store');
        Route::put('/projects/{project}/sources/{source}/file_upload_source/update', 'update')
            ->name('sources.file_upload_source.update');
        Route::post('/projects/{project}/sources/{source}/file_upload_source/run', 'run')
            ->name('sources.file_upload_source.run');
    }
);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(\App\Http\Controllers\Transformers\CsvTransformerTransformerController::class)->group(
    function () {
        Route::get('/projects/{project}/transformers/csv_transformer/create', 'create')
            ->name('transformers.csv_transformer.create');
        Route::get('/projects/{project}/transformers/{transformer}/csv_transformer/edit', 'edit')
            ->name('transformers.csv_transformer.edit');
        Route::post('/projects/{project}/transformers/csv_transformer/store', 'store')
            ->name('transformers.csv_transformer.store');
        Route::put('/projects/{project}/transformers/{transformer}/csv_transformer/update', 'update')
            ->name('transformers.csv_transformer.update');
        Route::post('/projects/{project}/transformers/{transformer}/csv_transformer/run', 'run')
            ->name('transformers.csv_transformer.run');
    }
);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->controller(\App\Http\Controllers\Sources\WebHookSourceController::class)->group(
    function () {
        Route::get('/projects/{project}/sources/web_hook/create', 'create')
            ->name('sources.web_hook.create');
        Route::get('/projects/{project}/sources/{source}/web_hook/edit', 'edit')
            ->name('sources.web_hook.edit');
        Route::post('/projects/{project}/sources/web_hook/store', 'store')
            ->name('sources.web_hook.store');
        Route::put('/projects/{project}/sources/{source}/web_hook/update', 'update')
            ->name('sources.web_hook.update');
        Route::post('/projects/{project}/sources/{source}/web_hook/run', 'run')
            ->name('sources.web_hook.run');
    }
);
