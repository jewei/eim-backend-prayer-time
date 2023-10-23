<?php

declare(strict_types=1);

return [
    'default' => env('LOG_CHANNEL', 'single'),
    'channels' => [
        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => 'debug',
            'replace_placeholders' => true,
        ],
    ],
];
