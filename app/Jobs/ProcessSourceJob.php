<?php

namespace App\Jobs;

use App\Events\SourceRunCompleteEvent;
use App\Events\TransformerRunCompleteEvent;
use App\Models\Source;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProcessSourceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public Source $source)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            logger('Getting Source '.$this->source->id);
            $this->source->run();
            SourceRunCompleteEvent::dispatch($this->source);
            logger('Done Source '.$this->source->id);
        } catch (\Exception $e) {
            $message = 'Error getting Source '.$this->source->id;
            logger($message);
            throw new \Exception($message);
        }
    }
}
