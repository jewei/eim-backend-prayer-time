<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Symfony\Component\Console\Exception\ExceptionInterface;

class ConsoleException extends Exception implements ExceptionInterface
{
    public function __construct(protected int $exitCode, ?string $message)
    {
        parent::__construct($message ?? 'Something went wrong.');
    }

    public function getExitCode(): int
    {
        return $this->exitCode;
    }
}
