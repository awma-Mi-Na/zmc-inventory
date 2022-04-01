<?php

if (!function_exists('check_exists_or_null')) {
    function check_exists_or_null(string $key, array $array)
    {
        return array_key_exists($key, $array) ? ($array[$key] ?? 0) : 0;
    }
}
