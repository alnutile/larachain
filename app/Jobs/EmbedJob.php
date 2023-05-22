<?php

namespace App\Jobs;

use App\LLMModels\OpenAi\EmbeddingsResponseDto;
use App\Models\DocumentChunk;
use Facades\App\LLMModels\OpenAi\ClientWrapper;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EmbedJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public DocumentChunk $chunk)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        /** @var EmbeddingsResponseDto $embeddings */
        $embeddings = ClientWrapper::getEmbedding($this->chunk->content);
        $this->chunk->embedding = $embeddings->embedding;
        $this->chunk->token_count = $embeddings->token_count;
        $this->chunk->save();
    }
}
