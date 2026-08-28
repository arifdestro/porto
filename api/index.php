<?php

// Vercel serverless: filesystem is read-only except /tmp
// Create required directories BEFORE Laravel boots
$tmpDirs = [
    '/tmp/bootstrap-cache',
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/framework/cache',
    '/tmp/storage/logs',
];

foreach ($tmpDirs as $dir) {
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Point Laravel cache paths to /tmp via env vars (must be set before boot)
$_ENV['APP_PACKAGES_CACHE'] = '/tmp/bootstrap-cache/packages.php';
$_ENV['APP_SERVICES_CACHE'] = '/tmp/bootstrap-cache/services.php';
$_ENV['APP_CONFIG_CACHE']   = '/tmp/bootstrap-cache/config.php';
$_ENV['APP_ROUTES_CACHE']   = '/tmp/bootstrap-cache/routes-v7.php';
$_ENV['APP_EVENTS_CACHE']   = '/tmp/bootstrap-cache/events.php';

require __DIR__ . '/../public/index.php';
