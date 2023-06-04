<?php

namespace App\ResponseType\Types;

use App\Models\ResponseType;
use App\ResponseType\BaseResponseType;
use App\ResponseType\ResponseDto;

class ChatGptRetrievalPlugin extends BaseResponseType
{
    public function handle(ResponseType $responseType): ResponseDto
    {

        $openApiFormat = [];


        $this->response_dto->response->raw->map(function ($document) {

            $openApiFormat = [];
            $openApiFormat['score'] = data_get($document, 'distance');
            $openApiFormat['content'] = data_get($document, 'content');
            $openApiFormat['embedding'] = data_get($document, 'embedding');
            $openApiFormat['id'] = data_get($document, 'id');
            return $openApiFormat;
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
