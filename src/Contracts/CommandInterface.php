<?php

declare(strict_types=1);

namespace App\Contracts;

interface CommandInterface
{
    public function handle(): void;
}
