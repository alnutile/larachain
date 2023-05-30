<?php

namespace App\Models;

use App\Exceptions\ResponseTypeMissingException;
use App\Outbound\OutboundEnum;
use App\ResponseType\BaseResponseType;
use App\ResponseType\Content;
use App\ResponseType\ContentCollection;
use App\ResponseType\ResponseDto;
use App\ResponseType\ResponseTypeEnum;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property ResponseTypeEnum $type
 * @property int $id
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

    protected $appends = [
        'type_formatted',
    ];

    public function getTypeFormattedAttribute()
    {
        return str($this->type->value)->headline()->toString();
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function response_types()
    {
        return $this->hasMany(ResponseType::class)->orderBy('order', 'ASC');
    }

    public function runResponseType(User $user, ResponseType $responseType, string $request): ResponseDto
    {
        $message = $this->makeMessage($request, $user);

        try {
            $this->makeResponseDto($message, $request);
            $this->processResponseType($responseType);

            return $this->currentResponseDto;
        } catch (\Exception $e) {
            logger($e->getMessage());

            return ResponseDto::from([
                'status' => 500,
                'message' => $message,
                'response' => ContentCollection::from([
                    'contents' => [
                        Content::from([
                            'content' => $e->getMessage(),
                        ]),
                    ],
                ]),
            ]);
        }
    }

    /**
     * @throws ResponseTypeMissingException
     */
    public function run(User $user, string $request): ResponseDto
    {
        $message = $this->makeMessage($request, $user);

        try {
            $this->makeResponseDto($message, $request);
            foreach ($this->response_types as $response_type_model) {
                $this->processResponseType($response_type_model);
            }

            return $this->currentResponseDto;
        } catch (\Exception $e) {
            logger($e->getMessage());

            return ResponseDto::from([
                'status' => 500,
                'message' => $message,
                'response' => ContentCollection::from([
                    'contents' => [
                        Content::from([
                            'content' => $e->getMessage(),
                        ]),
                    ],
                ]),
            ]);
        }
    }

    protected function processResponseType(ResponseType $response_type_model)
    {
        $responseTypes = config('larachain.response_types');
        $responseType = $response_type_model->type->value;
        $responseType = data_get($responseTypes, $responseType);
        $class = data_get($responseType, 'class', null);
        logger('Class', [$class]);

        if (! $class) {
            throw new \Exception('Response Type Missing Class');
        }

        $responseTypeClass = app($class, [
            'project' => $this->project,
            'response_dto' => $this->currentResponseDto,
        ]);

        /** @var BaseResponseType $responseTypeClass */
        $this->currentResponseDto = $responseTypeClass->handle($response_type_model);
    }

    protected function makeMessage(string $request, User $user): Message
    {
        return new Message([
            'role' => 'user',
            'content' => $request,
            'user_id' => $user->id,
            'project_id' => $this->project_id,
        ]);
    }

    protected function makeResponseDto(Message $message, string $request): ResponseDto
    {
        $dto = ResponseDto::from([
            'message' => $message,
            'response' => ContentCollection::from([
                'contents' => [
                    Content::from(['content' => $request]),
                ],
            ]),
        ]);

        $this->currentResponseDto = $dto;

        return $dto;
    }
}
