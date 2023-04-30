<?php

namespace App\Models;

use App\Ingress\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $team_id
 */
class Project extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function team()
    {
        return $this->belongsTo(Team::class);
    }
}
