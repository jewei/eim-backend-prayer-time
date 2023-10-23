<?php

declare(strict_types=1);

return [
    'name' => 'Application',
    'version' => '0.0.1',
    'env' => 'development',
    'timezone' => 'Asia/Kuala_Lumpur',
    'providers' => [
        \Illuminate\Database\DatabaseServiceProvider::class,
        \Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        \Illuminate\Mail\MailServiceProvider::class,
    ],
];
