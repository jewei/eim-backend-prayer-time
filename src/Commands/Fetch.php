<?php

declare(strict_types=1);

namespace App\Commands;

use App\Contracts\CommandInterface;

final class Fetch implements CommandInterface
{
    public function handle(): void
    {
        echo 'this is cool';
    }
}
