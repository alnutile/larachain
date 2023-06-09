<?php

namespace App\Jobs;

use App\Data\DataToDocumentDtoData;
use App\Ingress\StatusEnum;
use App\Models\Document;
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
        public DataToDocumentDtoData $dataToDocumentDtoData
    ) {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Document::create([
            'status' => StatusEnum::Pending,
            'guid' => $this->dataToDocumentDtoData->external_id,
            'source_id' => $this->dataToDocumentDtoData->source_id,
            'content' => $this->dataToDocumentDtoData->content,
        ]);
    }
}
