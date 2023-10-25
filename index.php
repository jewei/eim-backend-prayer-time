<?php

declare(strict_types=1);

$app = require_once __DIR__.'/bootstrap.php';

/**
 * Register routes.
 */
require __DIR__.'/routes.php';

/** @var App\Application $app */
$app->handleHttpRequest($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
