<?php

namespace App\ResponseType;

use App\Data\Filters;
use App\Models\Message;
use Spatie\LaravelData\Data;

class ResponseDto extends Data
{
    public function __construct(
        public Message $message,
        public ContentCollection $response,
        public int $status = 200,
        public Filters $filters = new Filters()
    ) {
    }
}
