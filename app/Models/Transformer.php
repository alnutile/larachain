<?php

namespace App\Models;

use App\Exceptions\SourceTypeMissingException;
use App\Source\Types\BaseSourceType;
use App\Transformers\TransformerTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transformer extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'prompt_token' => 'encrypted:array',
        'type' => TransformerTypeEnum::class
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * @throws SourceTypeMissingException
     */
    public function run()
    {
        try {
            //@TODO make this check in uses BaseSourceType
            $transformerType = $this->type->label();
            $transformerType = app("App\Transformers\Types\\".$transformerType, [
                'document' => $this,
            ]);
            /** @var BaseSourceType $sourceType */
            $sourceType->handle();
        } catch (\Exception $e) {
            //@TODO This exception needs to be more specific
            logger($e);
            throw new SourceTypeMissingException();
        }
    }
}
