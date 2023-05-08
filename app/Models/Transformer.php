<?php

namespace App\Models;

use App\Exceptions\TranformerTypeMissingException;
use App\Transformers\BaseTransformer;
use App\Transformers\TransformerTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Collection\Collection;

/**
 * @property int $id;
 * @property int $order;
 * @property TransformerTypeEnum $type;
 * @property Project $project;
 *
 * @method Project project()
 */
class Transformer extends Model
{
    use HasFactory;

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
            $transformerType = $this->type->label();

            foreach ($this->project->documents as $document) {
                $transformerType = app("App\Transformers\Types\\".$transformerType, [
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
