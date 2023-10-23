<?php

declare(strict_types=1);

namespace App;

use App\Exceptions\ConsoleException;
use Illuminate\Foundation\Application as BaseApplication;
use Symfony\Component\Console\Exception\CommandNotFoundException;

/**
 * The application with simple dependency injection container.
 */
class Application extends BaseApplication
{
    /**
     * Throw a console exception with the given data.
     *
     * @param  int  $code
     * @param  string  $message
     * @param  array<string, string>  $headers
     */
    public function abort($code, $message = '', array $headers = []): void
    {
        if ($code === 404) {
            throw new CommandNotFoundException($message);
        }

        throw new ConsoleException($code, $message);
    }
}
