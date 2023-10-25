<?php

declare(strict_types=1);

use App\Application;
use App\Dotenv;

/**
 * Autoloading from Composer generated PSR-4 autoloader instance.
 */
require __DIR__.'/vendor/autoload.php';

/**
 * Loads environment variables from `.env` to `$_ENV`.
 */
(new Dotenv(__DIR__))->load();

/**
 * Set default timezone.
 */
date_default_timezone_set('Asia/Kuala_Lumpur');

/**
 * Ensure default encoding is set.
 */
mb_internal_encoding('UTF-8');

/**
 * Include helper functions.
 */
require __DIR__.'/helpers.php';

/**
 * Create the application, the IoC container for dependency injection.
 */
$app = new Application();

/**
 * Initialize the application.
 */
$app->init();

/**
 * Return the application.
 */
return $app;
