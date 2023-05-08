<?php

namespace App\ResponseType\Types;

use App\Models\Document;
use App\Models\ResponseType;
use App\ResponseType\BaseResponseType;
use App\ResponseType\ResponseDto;

class VectorSearch extends BaseResponseType
{
    public function handle(ResponseType $responseType): ResponseDto
    {
        /** @phpstan-ignore-next-line */
        $results = Document::query()
            ->whereHas('source', function ($query) {
                $query->where('project_id', $this->project->id);
            })
            ->selectRaw('embedding <-> ? as distance, content',
                [$this->response_dto->message->embedding])
            ->orderByRaw('distance')
            ->get();

        return ResponseDto::from(
            [
                'message' => $this->response_dto->message->refresh(),
                'response' => $results,
            ]
        );
    }
}
