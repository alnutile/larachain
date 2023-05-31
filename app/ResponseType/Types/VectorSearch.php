<?php

namespace App\ResponseType\Types;

use App\Models\DocumentChunk;
use App\Models\ResponseType;
use App\ResponseType\BaseResponseType;
use App\ResponseType\Content;
use App\ResponseType\ContentCollection;
use App\ResponseType\ResponseDto;
use Illuminate\Support\Facades\File;

class VectorSearch extends BaseResponseType
{
    public function handle(ResponseType $responseType): ResponseDto
    {
        $query = DocumentChunk::query()
            ->join('documents', 'documents.id', '=', 'document_chunks.document_id')
            ->join('sources', 'sources.id', '=', 'documents.source_id')
            ->selectRaw('document_chunks.embedding <-> ? as distance, document_chunks.content',
                [$this->response_dto->message->embedding])
            ->where('sources.project_id', $this->project->id)
            ->when(!empty($this->response_dto->filters->getSources()), function($query) {
                $query->whereIn("sources.id", $this->response_dto->filters->getSources());
            })
            ->limit(20)
            ->orderByRaw('distance');

        $results = $query->get();

        return ResponseDto::from(
            [
                'message' => $this->response_dto->message->refresh(),
                'response' => ContentCollection::from([
                    'contents' => Content::collection($results),
                ]),
                'filters' => $this->response_dto->filters
            ]
        );
    }
}
