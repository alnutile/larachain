<?php

namespace App\Models;

use App\Exceptions\ResponseTypeMissingException;
use App\ResponseType\BaseResponseType;
use App\ResponseType\ResponseDto;
use App\ResponseType\ResponseTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property ResponseTypeEnum $type
 * @property int $project_id
 * @property Project $project;
 * @property array $prompt_token;
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


}
