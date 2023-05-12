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

        /**
         * @TODO move this into the UI
         */
        $token_limit = data_get($responseType->meta_data, "token_limit", 750);

        foreach ($this->response_dto->response as $document) {
            $combinedContent .= $document->content;
            if (strlen($combinedContent) >= $token_limit) {
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
