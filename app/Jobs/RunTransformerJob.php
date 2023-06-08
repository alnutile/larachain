<?php

namespace App\Jobs;

use App\Events\TransformersDoneEvent;
use App\Models\Transformer;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RunTransformerJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Transformer $transformer)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->transformer->run();

        TransformersDoneEvent::dispatch($this->transformer->project, str($this->transformer->type->name)->headline());
    }
}
