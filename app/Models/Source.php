<?php

namespace App\Models;

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
 * @property string $type
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
}
