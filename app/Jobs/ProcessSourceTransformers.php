<?php

namespace App\Jobs;

use App\Models\Document;
use App\Models\Transformer;
use App\Transformer\BaseTransformer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessSourceTransformers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Document $document)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        logger('Job ProcessSourceTransformers');

        /** @var Transformer $transformerModel */
        foreach ($this->document->source->project->transformers as $transformerModel) {
            $transformerType = $transformerModel->type->value;
            $sourceType = $this->document->source->type->value;
            $requires = config('larachain.transformers.'.$transformerType.'.requires.sources', []);
            $needsToRun = in_array($sourceType, $requires);
            if (! $needsToRun) {
                $needsToRun = config('larachain.transformers.'.$transformerType.'.global', false);
            }

            $transformer = config('larachain.transformers.'.$transformerType);

            if ($needsToRun) {
                /** @var BaseTransformer $transformer */
                $transformer = app()->make($transformer['class'], [
                    'document' => $this->document,
                ]);
                $transformer->handle($transformerModel);
            }
        }
    }
}
