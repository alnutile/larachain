<?php

namespace App\Models;

use App\Ingress\IngressTypeEnum;
use App\Ingress\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Pgvector\Laravel\Vector;

/**
 * @property string $content
 * @property int $token_count;
 * @property array $embedding
 * @property array $meta_data
 */
class Document extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'status' => StatusEnum::class,
        'type' => IngressTypeEnum::class,
        'meta_data' => 'array',
        'embedding' => Vector::class,
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
