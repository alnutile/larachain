<?php

namespace App\Models;

use App\ResponseType\ResponseDto;
use App\ResponseType\ResponseTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property ResponseTypeEnum $type
 * @property int $outbound_id
 * @property Outbound $outbound;
 * @property array $prompt_token;
 *
 * @method Outbound outbound()
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

    public function outbound()
    {
        return $this->belongsTo(Outbound::class);
    }
}
