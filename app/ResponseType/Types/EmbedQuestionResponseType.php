<?php

namespace App\ResponseType\Types;

use App\Models\ResponseType;
use App\ResponseType\BaseResponseType;
use App\ResponseType\ResponseDto;
use Facades\App\LLMModels\OpenAi\ClientWrapper;

class EmbedQuestionResponseType extends BaseResponseType
{
    public function handle(ResponseType $responseType): ResponseDto
    {
        $results = ClientWrapper::getEmbedding($this->response_dto->message->content);
        $this->response_dto->message->embedding = $results->embedding;
        $this->response_dto->message->save();

        return ResponseDto::from(
            [
                'message' => $this->response_dto->message->refresh(),
                'response' => null,
            ]
        );
    }
}
