<?php

namespace App\Models;

use App\Ingress\IngressTypeEnum;
use App\Ingress\StatusEnum;
use App\Source\SourceTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Pgvector\Laravel\Vector;

/**
 * @property string $content
 * @property int $id;
 * @property int $token_count;
 * @property array $embedding
 * @property array $meta_data
 * @property Source $source
 * @property Project $project
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

    public function pathToFile()
    {
        if ($this->source->type === SourceTypeEnum::WebFile) {
            return sprintf(
                storage_path('app/projects/%d/sources/%d/%s'),
                $this->source->project_id,
                $this->source->id,
                $this->guid);
        }

            return null;
    }

    public function document_chunks()
    {
        return $this->hasMany(DocumentChunk::class);
    }
}
