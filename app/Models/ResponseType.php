<?php

namespace App\Models;

use App\Exceptions\ResponseTypeMissingException;
use App\Exceptions\TranformerTypeMissingException;
use App\ResponseType\BaseResponseType;
use App\ResponseType\ResponseDto;
use App\ResponseType\ResponseTypeEnum;
use App\Transformers\BaseTransformer;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property ResponseTypeEnum $type
 * @property int $project_id
 * @property Project $project;
 *
 * @method Project project()
 */
class ResponseType extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected ResponseDto $currentResponseDto;

    protected $casts = [
        'prompt_token' => 'encrypted:array',
        'type' => ResponseTypeEnum::class,
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * @throws ResponseTypeMissingException
     */
    public function run(User $user, string $request)
    {
        //make a message
        //make a responseLinkDto
        try {
            /**
             * @TODO move this to a queue
             */
            $responseType = $this->type->label();

            $message = new Message([
                'role' => "user",
                "content" => $request,
                'user_id' => $user->id,
                "project_id" => $this->project_id,
            ]);

            $dto = ResponseDto::from([
               "message" => $message,
            ]);

            $this->currentResponseDto = $dto;

            foreach ($this->project->response_types as $response_type_model) {
                $responseType = app("App\ResponseType\Types\\".$responseType, [
                    'project' => $this->project,
                    'response_dto' => $dto
                ]);
                /** @var BaseResponseType $responseType */
                $this->currentResponseDto = $responseType->handle($response_type_model);
            }
        } catch (\Exception $e) {
            logger($e);
            throw new ResponseTypeMissingException();
        }
    }

}
