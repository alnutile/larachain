<?php

namespace App\Listeners;

use App\Events\SourceRunCompleteEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RunTransformersListener
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
        //
    }
}
