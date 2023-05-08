<?php

namespace App\ResponseType\Types;

use App\Models\ResponseType;
use App\ResponseType\BaseResponseType;
use App\ResponseType\ResponseDto;
use Facades\App\LLMModels\OpenAi\ClientWrapper;

class EmbedQuestionResponseType extends BaseResponseType
{

    function handle(ResponseType $responseType): ResponseDto
    {
        //Get the question from message
        $results = ClientWrapper::getEmbedding($this->response_dto->message->content);
        //turn it into embedding
        //save it to a new ???
        //make a new dto
        //$this->response_dto->message->embedding =  $results->embedding;

        return ResponseDto::from(
            [
                'message' => $this->response_dto->message,
                'response' => null
            ]
        );
    }
}
