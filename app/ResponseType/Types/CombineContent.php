<?php

namespace App\ResponseType\Types;

use App\Models\ResponseType;
use App\ResponseType\BaseResponseType;
use App\ResponseType\Content;
use App\ResponseType\ContentCollection;
use App\ResponseType\ResponseDto;

class CombineContent extends BaseResponseType
{
    public function handle(ResponseType $responseType): ResponseDto
    {
        $combinedContent = '';

        /**
         * @TODO move this into the UI
         */
        $token_limit = data_get($responseType->meta_data, 'token_limit', 750);

        foreach ($this->response_dto->response->contents as $document) {
            $combinedContent .= $document->content;
            if ($this->count_tokens($combinedContent) >= $token_limit) {
                break;
            }
        }

        return ResponseDto::from(
            [
                'message' => $this->response_dto->message->refresh(),
                'response' => ContentCollection::from([
                    'contents' => [
                        Content::from([
                            'content' => $combinedContent,
                            'raw' => [$combinedContent],
                        ])],
                ]),
                'filters' => $this->response_dto->filters,
            ]
        );
    }

    protected function count_tokens($string)
    {
        // Add spaces before punctuation, then split the string by spaces
        $tokens = preg_split('/\s+/', preg_replace('/([?.!])/', ' $1', $string));

        // Return the count of the tokens
        return count($tokens);
    }
}
