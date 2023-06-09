<?php

namespace App\Models;

use App\Exceptions\TransformerTypeMissingException;
use App\Transformer\BaseTransformer;
use App\Transformer\TransformerEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id;
 * @property int $order;
 * @property int $project_id;
 * @property array $meta_data;
 * @property TransformerEnum $type;
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
        'type' => TransformerEnum::class,
        'meta_data' => 'encrypted:array',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * @throws TransformerTypeMissingException
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

            /**
             * @NOTE was not getting great results with the
             * through relationship
             */
            foreach ($this->project->sources as $source) {
                foreach ($source->documents as $document) {
                    logger('Running Transformer '.$class);

                    $transformerType = app($class, [
                        'document' => $document,
                    ]);
                    /** @var BaseTransformer $transformerType */
                    $transformerType->handle($this);
                }
            }
        } catch (\Exception $e) {
            logger($e);
            throw new TransformerTypeMissingException();
        }
    }
}
