<?php

namespace App\Models;

/**
 * @property object $type
 */
class BaseTypeModel extends \Illuminate\Database\Eloquent\Model
{
    public function getTypeFormattedAttribute()
    {
        return str($this->type->value)->headline()->toString();
    }
}
