<?php

namespace App\ResponseType\Types;

use App\Models\ResponseType;
use App\ResponseType\BaseResponseType;
use App\ResponseType\ResponseDto;

class CombineContent extends BaseResponseType
{
    public function handle(ResponseType $responseType): ResponseDto
    {
        $combinedContent = '';

        foreach ($this->response_dto->response as $document) {
            $combinedContent .= $document->content;
            if (strlen($combinedContent) >= 750) {
                break;
            }
        }

        return ResponseDto::from(
            [
                'message' => $this->response_dto->message->refresh(),
                'response' => $combinedContent,
            ]
        );
    }
}
