<?php

declare(strict_types=1);

namespace App;

use App\Contracts\CommandInterface;

abstract class Command implements CommandInterface
{
    public function __construct(protected Application $app)
    {
    }
}
