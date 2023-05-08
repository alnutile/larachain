<?php

namespace App\ResponseType;

use App\Models\Message;
use App\Models\Project;
use App\Models\ResponseType;

abstract class BaseResponseType
{

    public function __construct(
        public Project $project,
        public ResponseDto $response_dto,
    )
    {
    }

    abstract function handle(ResponseType $responseType) : ResponseDto;
}
