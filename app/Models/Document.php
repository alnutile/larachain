<?php

namespace App\Models;

use App\Ingress\IngressTypeEnum;
use App\Ingress\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Pgvector\Laravel\Vector;

/**
 * @property string $content
 * @property int $token_count;
 * @property array $embedding
 * @property array $meta_data
 *
 * @method Source source()
 * @method Project project()
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

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function project()
    {
        return $this->hasOneThrough(
            Project::class,
            Source::class,
            'project_id', // Foreign key on the sources table...
            'id', // Foreign key on the projects table...
            'source_id', // Local key on the documents table...
            'id' // Local key on the sources table...
        );
    }
}
