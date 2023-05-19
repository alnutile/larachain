<?php

namespace App\Models;

use App\Exceptions\TranformerTypeMissingException;
use App\Transformers\BaseTransformer;
use App\Transformers\TransformerTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id;
 * @property int $order;
 * @property TransformerTypeEnum $type;
 * @property Project $project;
 *
 * @method Project project()
 */
class Transformer extends BaseTypeModel
{
    use HasFactory;

    protected $appends = [
        'type_formatted',
    ];

    protected $guarded = [];

    protected $casts = [
        'prompt_token' => 'encrypted:array',
        'type' => TransformerTypeEnum::class,
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * @throws TranformerTypeMissingException
     */
    public function run()
    {
        try {
            $transformerTypes = config('larachain.transformers');
            $transformerType = $this->type->value;
            $transformerType = data_get($transformerTypes, $transformerType);
            $class = data_get($transformerType, 'class', null);
            if (! $class) {
                throw new \Exception('Transformer Missing Class');
            }

            foreach ($this->project->documents as $document) {
                logger('Running Transformer '.$class);

                $transformerType = app($class, [
                    'document' => $document,
                ]);
                /** @var BaseTransformer $transformerType */
                $transformerType->handle($this);
            }
        } catch (\Exception $e) {
            logger($e);
            throw new TranformerTypeMissingException();
        }
    }
}
