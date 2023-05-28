<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Source;
use Illuminate\Support\Facades\DB;

class DeleteSourceController extends Controller
{
    public function delete(Source $source)
    {

        $projectId = $source->project_id;

        DB::transaction(function () use ($source) {
            /** @phpstan-ignore-next-line */
            $source->documents->each(function (Document $document) {
               $document->document_chunks()->delete();
               $document->delete();
            });

            $source->delete();
        });

        request()->session()->flash('flash.banner', 'Source deleted...');

        return to_route('projects.show', [
            'project' => $projectId,
        ]);
    }
}
