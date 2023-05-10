<?php

namespace App\ResponseType;

use App\Models\Message;
use Spatie\LaravelData\Data;

class ResponseDto extends Data
{
    public function __construct(
        public Message $message,
        public mixed $response,
        public int $status = 200
    ) {
    }
}
