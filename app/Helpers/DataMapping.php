<?php

namespace App\Helpers;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class DataMapping
{
    public function map(array $keys, array $data): array
    {
        return collect($keys)->mapWithKeys(function ($key) use ($data) {
            $label = Str::afterLast($key, '.');

            return [$label => Arr::get($data, $key)];
        })->all();
    }
}
