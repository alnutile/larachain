<?php

namespace App\ResponseType;

use Illuminate\Support\Collection;
use Spatie\LaravelData\Support\DataProperty;
use function Pest\Laravel\instance;

class ContentsCaster implements \Spatie\LaravelData\Casts\Cast
{

    public function cast(DataProperty $property, mixed $value, array $context): Collection
    {
        if(!$value instanceof Collection) {
            $value = collect($value);
        }

        return $value->map(function($item) {
            return ($item instanceof Content) ? $item : Content::from($item);
        });
    }
}
