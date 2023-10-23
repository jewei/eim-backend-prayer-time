<?php

declare(strict_types=1);

/**
 * Autoloading from Composer generated PSR-4 autoloader instance.
 */
require __DIR__.'/vendor/autoload.php';

/**
 * Create the application, the IoC container for dependency injection.
 */
$app = new Illuminate\Foundation\Application(__DIR__);

/**
 * Set paths for the application.
 */
$app
    ->useAppPath('src')
    ->useBootstrapPath('storage')
    ->useConfigPath('config')
    ->useDatabasePath('database')
    ->useEnvironmentPath(__DIR__)
    ->useLangPath('lang')
    ->usePublicPath('public')
    ->useStoragePath('storage');

/**
 * Bind the core application interfaces.
 */
$app->singleton(Illuminate\Contracts\Console\Kernel::class, App\Kernel::class);
$app->singleton(Illuminate\Contracts\Debug\ExceptionHandler::class, Illuminate\Foundation\Exceptions\Handler::class);

/**
 * Return the instantiated application.
 */
return $app;
