<?php

namespace App\Models;

use App\Exceptions\ResponseTypeMissingException;
use App\Outbound\OutboundEnum;
use App\ResponseType\BaseResponseType;
use App\ResponseType\ResponseDto;
use App\ResponseType\ResponseTypeEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property ResponseTypeEnum $type
 * @property int $project_id
 * @property Project $project;
 * @property array $prompt_token;
 * @property Collection $response_types;
 *
 * @method Project project()
 */
class Outbound extends Model
{
    use HasFactory;

    protected ResponseDto $currentResponseDto;

    protected $guarded = [];

    protected $casts = [
        'type' => OutboundEnum::class,
        'active' => 'bool',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function response_types()
    {
        return $this->hasMany(ResponseType::class)->orderBy('order');
    }

    /**
     * @throws ResponseTypeMissingException
     */
    public function run(User $user, string $request): ResponseDto
    {
        $message = new Message([
            'role' => 'user',
            'content' => $request,
            'user_id' => $user->id,
            'project_id' => $this->project_id,
        ]);

        try {

            $dto = ResponseDto::from([
                'message' => $message,
            ]);

            $this->currentResponseDto = $dto;

            foreach ($this->response_types as $response_type_model) {
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

            return ResponseDto::from([
                'status' => 500,
                'message' => $message,
                'response' => $e->getMessage(),
            ]);
        }
    }
}
