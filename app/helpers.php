<?php

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
