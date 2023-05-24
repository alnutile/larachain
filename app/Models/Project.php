<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

/**
 * @property int $id
 * @property int $team_id
 * @property string $name
 * @property bool $active
 * @property bool $private
 * @property bool $web_page,
 * @property string $slug
 * @property array $meta_data
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property Collection $documents
 * @property Collection $sources
 * @property Collection $response_types
 * @property Collection $transformers
 */
class Project extends Model
{
    use HasSlug, HasFactory;

    protected $appends = [
        'slug_formatted',
    ];

    protected $casts = [
        'meta_data' => 'encrypted:array',
        'private' => 'bool',
        'active' => 'bool',
    ];

    protected $guarded = [];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function documents()
    {
        return $this->hasManyThrough(Document::class, Source::class);
    }

    public function transformers()
    {
        return $this->hasMany(Transformer::class)->orderBy('order');
    }

    public function sources()
    {
        return $this->hasMany(Source::class)->orderBy('order');
    }

    public function outbounds()
    {
        return $this->hasMany(Outbound::class);
    }

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->skipGenerateWhen(
                fn () => $this->slug != null
            )
            ->saveSlugsTo('slug');
    }

    public function getSlugFormattedAttribute()
    {
        if (! $this->slug) {
            return null;
        }

        return sprintf('%s/shared/%s', config('app.url'), $this->slug);
    }
}
