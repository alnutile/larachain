<?php

namespace App\Models;

class BaseTypeModel extends \Illuminate\Database\Eloquent\Model
{

    public function getTypeFormattedAttribute()
    {
        return str($this->type->value)->headline()->toString();
    }
}
