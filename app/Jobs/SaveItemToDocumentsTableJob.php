<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SaveItemToDocumentsTableJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public string $content,
        public mixed $unique_id,
        public mixed $project_id,
        public array $labels
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
    }
}
