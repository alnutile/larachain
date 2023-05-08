<?php

namespace App\Models;

use App\Exceptions\SourceTypeMissingException;
use App\Source\SourceTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
class Source extends Model
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
        $sourceTypeFile = sprintf('%s.php', $statusType);
        try {
            app("App\Source\Types\\".$statusType, [
                'source' => $this,
            ])->handle();
        } catch (\Exception $e) {
            logger($e);
            throw new SourceTypeMissingException();
        }

    }
}
