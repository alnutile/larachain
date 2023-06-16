<?php

namespace App\Listeners;

use App\Events\SourceRunCompleteEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class RunTransformersListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(SourceRunCompleteEvent $event): void
    {
        //see what transformers exists
        //see if any are "related" to this source type
    }
}
