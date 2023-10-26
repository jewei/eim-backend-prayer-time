<?php

declare(strict_types=1);

namespace App\Commands;

use App\Command;

final class Fetch extends Command
{
    /**
     * @param  array<int, string>  $arguments
     */
    public function handle(array $arguments): void
    {
        echo 'this is cool';
    }
}
