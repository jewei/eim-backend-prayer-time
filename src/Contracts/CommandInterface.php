<?php

declare(strict_types=1);

namespace App\Contracts;

interface CommandInterface
{
    /**
     * @param  array<int, string>  $arguments
     */
    public function handle(array $arguments): void;
}
