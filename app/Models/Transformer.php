<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transformer extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'prompt_token' => 'encrypted:array',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
