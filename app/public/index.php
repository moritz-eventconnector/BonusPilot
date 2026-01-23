<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../storage/framework/maintenance.php')) {
    require $maintenance;
}

$autoloadPath = __DIR__.'/../vendor/autoload.php';
if (!file_exists($autoloadPath)) {
    http_response_code(500);
    echo "Missing vendor dependencies. Run 'composer install' in the Laravel app directory.";
    exit(1);
}

require $autoloadPath;

$app = require_once __DIR__.'/../bootstrap/app.php';

$app->handleRequest(Request::capture());
