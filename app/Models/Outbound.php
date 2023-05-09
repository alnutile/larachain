<?php

namespace App\Models;

use App\Outbound\OutboundEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Outbound extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'type' => OutboundEnum::class,
        'active' => "bool"
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }
}
