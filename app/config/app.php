<?php

return [
    'name' => env('APP_NAME', 'BonusPilot'),
    'env' => env('APP_ENV', 'production'),
    'debug' => (bool) env('APP_DEBUG', false),
    'url' => env('APP_URL', 'https://example.com'),
    'timezone' => 'UTC',
    'locale' => 'de',
    'fallback_locale' => 'en',
    'faker_locale' => 'en_US',
    'key' => env('APP_KEY'),
    'cipher' => 'AES-256-CBC',
    'asset_url' => env('ASSET_URL'),
];
