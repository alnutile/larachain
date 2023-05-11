<?php

namespace App\Jobs;

use App\Events\TransformerRunCompleteEvent;
use App\Models\Source;
use App\Models\Transformer;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessTransformerJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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
        try {
            logger('Running Transformer '.$this->transformer->id);
            $this->transformer->run();
            TransformerRunCompleteEvent::dispatch($this->transformer);
            logger('Done Running Transformer '.$this->transformer->id);
        } catch (\Exception $e) {
            $message = 'Error Running Transformer '.$this->transformer->id;
            logger($message);
            throw new \Exception($message);
        }
    }
}
