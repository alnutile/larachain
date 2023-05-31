<?php

namespace App\ResponseType\Types;

use App\Models\ResponseType;
use App\ResponseType\BaseResponseType;
use App\ResponseType\ResponseDto;

class StringReplace extends BaseResponseType
{
    public function handle(ResponseType $responseType): ResponseDto
    {

        $search = data_get($responseType->meta_data, 'search', []);
        $replace = data_get($responseType->meta_data, 'replace', []);

        $this->response_dto->response->contents->map(function ($document) use ($search, $replace) {
            $document->content = str($document->content)->replace($search, $replace);

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
