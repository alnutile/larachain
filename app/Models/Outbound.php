<?php

namespace App\Models;

use App\Exceptions\ResponseTypeMissingException;
use App\Outbound\OutboundEnum;
use App\ResponseType\BaseResponseType;
use App\ResponseType\ResponseDto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outbound extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'type' => OutboundEnum::class,
        'active' => "bool"
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }

    /**
     * @throws ResponseTypeMissingException
     */
    public function run(User $user, string $request): ResponseDto
    {
        try {

            $message = new Message([
                'role' => 'user',
                'content' => $request,
                'user_id' => $user->id,
                'project_id' => $this->project_id,
            ]);

            $dto = ResponseDto::from([
                'message' => $message,
            ]);

            $this->currentResponseDto = $dto;

            foreach ($this->project->response_types as $response_type_model) {
                $responseType = $response_type_model->type->label();
                $responseTypeClass = app("App\ResponseType\Types\\".$responseType, [
                    'project' => $this->project,
                    'response_dto' => $dto,
                ]);
                /** @var BaseResponseType $responseTypeClass */
                $this->currentResponseDto = $responseTypeClass->handle($response_type_model);
            }

            return $this->currentResponseDto;
        } catch (\Exception $e) {
            logger($e);
            throw new ResponseTypeMissingException();
        }
    }
}
