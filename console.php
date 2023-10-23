#!/usr/bin/env php
<?php

declare(strict_types=1);

/** @var Illuminate\Foundation\Application */
$app = require_once __DIR__.'/bootstrap.php';

/** @var App\Kernel */
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);

$status = $kernel->handle(
    $input = new Symfony\Component\Console\Input\ArgvInput,
    new Symfony\Component\Console\Output\ConsoleOutput
);

$kernel->terminate($input, $status);

exit($status);
