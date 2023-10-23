<?php

declare(strict_types=1);

/** @var Illuminate\Foundation\Application */
$app = require_once __DIR__.'/bootstrap.php';

/** @var Illuminate\Foundation\Http\Kernel */
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
)->send();

$kernel->terminate($request, $response);
