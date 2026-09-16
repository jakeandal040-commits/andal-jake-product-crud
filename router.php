<?php
/**
 * Router for PHP's built-in development server.
 *
 * Start the application with:
 * php -S localhost:8000 router.php
 */

$requestPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$publicFile = __DIR__ . '/public' . $requestPath;

// Let the built-in server return real public assets directly.
if ($requestPath !== '/' && is_file($publicFile)) {
    return false;
}

require __DIR__ . '/public/index.php';
