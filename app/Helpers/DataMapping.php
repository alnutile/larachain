<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use Illuminate\Support\Arr;

class DataMapping
{

    public function map($keys, $data) : array {
        return collect($keys)->mapWithKeys(function($key) use ($data){
            $label = Str::afterLast($key, ".");
            return [$label => Arr::get($data, $key)];
        })->all();
    }

}
