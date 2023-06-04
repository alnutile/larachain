<?php

namespace App\ResponseType\Types;

use App\Models\ResponseType;
use App\ResponseType\BaseResponseType;
use App\ResponseType\ResponseDto;

class ChatGptRetrieval extends BaseResponseType
{
    public function handle(ResponseType $responseType): ResponseDto
    {

        $this->response_dto->response->contents->map(function ($document) {
            $document->content = str($document->content)->toString();

            return $document;
        });

        return ResponseDto::from(
            [
                'message' => $this->response_dto->message->refresh(),
                'response' => $this->response_dto->response,
                'filters' => $this->response_dto->filters,
            ]
        );
    }
}
