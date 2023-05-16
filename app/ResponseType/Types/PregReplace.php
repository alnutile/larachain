<?php

namespace App\ResponseType\Types;

use App\Models\ResponseType;
use App\ResponseType\BaseResponseType;
use App\ResponseType\Content;
use App\ResponseType\ContentCollection;
use App\ResponseType\ResponseDto;

class PregReplace extends BaseResponseType
{
    public function handle(ResponseType $responseType): ResponseDto
    {

        /**
         * @NOTE you can use the meta_data or prompt_token
         * JSON area for storing encrypted settings
         */
        $preg_replace_pattern = data_get($responseType->meta_data, 'preg_replace_pattern', null);
        $preg_replace_replacement = data_get($responseType->meta_data, 'preg_replace_replacement', null);
        if($preg_replace_replacement === "''") {
            $preg_replace_replacement = null;
        }

        if($preg_replace_pattern) {
                $this->response_dto->response->contents->map(function ($document) use ($preg_replace_pattern, $preg_replace_replacement) {
                $document->content = preg_replace($preg_replace_pattern, $preg_replace_replacement, $document->content);

                return $document;
            });
        }

        return ResponseDto::from(
            [
                'message' => $this->response_dto->message->refresh(),
                'response' => $this->response_dto->response,
            ]
        );
    }
}
