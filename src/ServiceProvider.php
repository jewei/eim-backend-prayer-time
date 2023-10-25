<?php

declare(strict_types=1);

namespace App;

abstract class ServiceProvider
{
    public function __construct(
        protected Application $app,
    ) {
    }

    public function boot(Application $app): void
    {
    }
}
