<?php

use Illuminate\Support\Stringable;

if (! function_exists('remove_ascii')) {
    function remove_ascii($string): string
    {
        return preg_replace('/[^\x00-\x7F]+/', '', $string);
    }
}

if (! function_exists('clean_messages')) {
    function clean_messages(array $messages): array
    {
        return collect($messages)->map(function ($item) {
            return [
                'role' => $item['role'],
                'content' => $item['content'],
            ];
        })->toArray();
    }
}

if (! function_exists('file_name_from_url')) {
    function file_name_from_url(string $url): string
    {
        return str($url)->beforeLast('?')->afterLast('/')
            ->when(! str($url)->endsWith('.html'), function (Stringable $string) {
                return $string->append('.html');
            })
            ->whenStartsWith('.', function ($item) {
                /** @var Stringable $item */
                return $item->prepend('index');
            })->toString();
    }
}
