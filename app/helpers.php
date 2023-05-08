<?php

if (! function_exists('remove_ascii')) {
    function remove_ascii($string): string
    {
        return preg_replace('/[^\x00-\x7F]+/', '', $string);
    }
}
