<?php

namespace App\ResponseType\Types;

use App\Models\ResponseType;
use App\ResponseType\BaseResponseType;
use App\ResponseType\Content;
use App\ResponseType\ContentCollection;
use App\ResponseType\ResponseDto;

class StringRemove extends BaseResponseType
{
    public function handle(ResponseType $responseType): ResponseDto
    {

        /**
         * @NOTE you can use the meta_data or prompt_token
         * JSON area for storing encrypted settings
         */
        $remove = data_get($responseType->meta_data, 'string', []);

        if(!empty($remove)) {
            $this->response_dto->response->contents->map(function ($document) use ($remove) {
                $document->content = str($document->content)
                    ->remove($remove)->toString();

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
