<?php

namespace App\Models;

use App\Source\SourceTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'meta_data' => 'encrypted:array',
        'type' => SourceTypeEnum::class,
    ];
}
