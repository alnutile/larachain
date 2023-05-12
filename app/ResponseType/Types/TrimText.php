<?php

namespace App\ResponseType\Types;

use App\Models\ResponseType;
use App\ResponseType\BaseResponseType;
use App\ResponseType\ResponseDto;

class TrimText extends BaseResponseType
{
    public function handle(ResponseType $responseType): ResponseDto
    {
        foreach ($this->response_dto->response as $index => $document) {
            $this->response_dto->response[$index] = str($document->content);
        }

        return ResponseDto::from(
            [
                'message' => $this->response_dto->message->refresh(),
                'response' => $this->response_dto->response,
            ]
        );
    }
}
