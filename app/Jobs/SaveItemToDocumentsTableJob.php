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
            'type' => $this->dataToDocumentDtoData->type,
            'guid' => $this->dataToDocumentDtoData->external_id,
            'project_id' => $this->dataToDocumentDtoData->project_id,
            'meta_data' => $this->dataToDocumentDtoData->meta_data,
            'content' => $this->dataToDocumentDtoData->content,
        ]);
    }
}
