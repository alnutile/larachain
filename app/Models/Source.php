<?php

namespace App\Models;

use App\Exceptions\SourceTypeMissingException;
use App\Source\SourceTypeEnum;
use App\Source\Types\BaseSourceType;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property int $id
 * @property string $name
 * @property string|null $description
 * @property array|null $meta_data
 * @property int $project_id
 * @property int $order
 * @property SourceTypeEnum $type
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class Source extends BaseTypeModel
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'meta_data' => 'encrypted:array',
        'type' => SourceTypeEnum::class,
    ];

    protected function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * @throws SourceTypeMissingException
     */
    public function run()
    {
        $statusType = $this->type->label();
        try {
            logger('Running source'.$statusType);
            //@TODO make this check in uses BaseSourceType
            $sourceType = app("App\Source\Types\\".$statusType, [
                'source' => $this,
            ]);
            /** @var BaseSourceType $sourceType */
            return $sourceType->handle();
        } catch (\Exception $e) {
            //@TODO This exception needs to be more specific
            logger($e);
            throw new SourceTypeMissingException();
        }
    }
}
