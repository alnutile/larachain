<?php

namespace App\ResponseType\Types;

use App\Models\ResponseType;
use App\ResponseType\BaseResponseType;
use App\ResponseType\ResponseDto;
use Illuminate\Support\Arr;

class CombineContent extends BaseResponseType
{
    public function handle(ResponseType $responseType): ResponseDto
    {
        $combinedContent = '';

        $response = Arr::wrap($this->response_dto->response);

        foreach ($response as $document) {
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
