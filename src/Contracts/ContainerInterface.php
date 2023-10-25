<?php

declare(strict_types=1);

namespace App\Contracts;

/**
 * To be compatible with PSR-11's \Psr\Container\ContainerInterface.
 */
interface ContainerInterface
{
    /** @phpstan-ignore-next-line */
    public function get(string $id);

    public function has(string $id): bool;
}
