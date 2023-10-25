<?php

declare(strict_types=1);

return [
    'providers' => [
        App\Providers\Config::class,
        App\Providers\Database::class,
        App\Providers\Http::class,
        App\Providers\Logger::class,
        App\Providers\Mailer::class,
        App\Providers\Router::class,
    ],
    'database' => base_path('/database/database.sqlite'),
];
