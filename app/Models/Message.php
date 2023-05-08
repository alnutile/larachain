<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Pgvector\Laravel\Vector;

/**
 * @property int $id
 * @property string $role
 * @property int $project_id
 * @property int $user_id
 * @property string $content
 * @property array $embedding
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\Models\Project $project
 * @property-read \App\Models\User $user
 */
class Message extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'embedding' => Vector::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
