<?php

namespace App\Listeners;

use App\Events\SourceRunCompleteEvent;

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
