<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $team_id
 * @property string $name
 * @property bool $active
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 */
class Project extends Model
{
    use HasFactory;

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
}
