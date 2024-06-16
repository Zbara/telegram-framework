<?php

use App\Services\LanguageService;

if (!function_exists('translate')) {
    function translate(
        string $key,
        array  $replace = null
    ): string
    {
        return LanguageService::getInstance()
            ->getText($key, $replace);
    }
}
if (!function_exists('is_url')) {
    function is_url($url): bool|int
    {
        return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url);
    }
}

if (!function_exists('filterText')) {
    function filterText(
        string $text,
    ): string
    {
        return trim(preg_replace('/\s*(--(?!aspect|ar|chaos|iw|no|stylize|s)\S+)(?:\s+\S+)?/', '', $text));
    }
}
