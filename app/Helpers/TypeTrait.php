<?php

namespace App\Helpers;

use Illuminate\Support\Arr;

trait TypeTrait
{
    public static function toArray(string $type = 'sources'): array
    {
        $config = config('larachain.'.$type);

        return collect($config)->filter(function ($item) {
            return data_get($item, 'active') === 1;
        })->map(function ($item, $key) use ($type) {
            if (! data_get($item, 'route')) {
                $item['route'] = sprintf('%s.%s.create', $type, $key);
            }

            if (! data_get($item, 'id')) {
                $item['id'] = $key;
            }

            if (! data_get($item, 'icon')) {
                $item['icon'] = self::randomIcon();
            }

            if (! data_get($item, 'background')) {
                $item['background'] = self::randomColor();
            }

            return $item;
        })->toArray();
    }

    protected static function randomColor(): string
    {
        return Arr::random([
            'bg-red-700',
            'bg-green-500',
            'bg-sky-500',
            'bg-indigo-500',
            'bg-slate-800',
        ]);
    }

    protected static function randomIcon()
    {
        return Arr::random([
            'ArrowDownTrayIcon',
            'Bars4Icon',
            'DocumentIcon',
            'ArrowsRightLeftIcon',
            'ChatBubbleLeftIcon',
            'PhoneIcon',
            'MegaphoneIcon',
        ]);
    }
}
