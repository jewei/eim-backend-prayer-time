<?php

declare(strict_types=1);

namespace App;

use Exception;

/**
 * Simple config class that literally takes value from .env.
 *
 * In production, better to use enviroment variable package like vlucas/phpdotenv
 * or symfony/dotenv.
 */
final class Dotenv
{
    public function __construct(
        protected string $basePath = __DIR__,
        protected string $envPath = '.env',
    ) {
        $this->envPath = $basePath.DIRECTORY_SEPARATOR.$envPath;
    }

    public function load(): void
    {
        if (! is_readable($this->envPath)) {
            throw new Exception('Cannot find env file: '.$this->envPath);
        }

        $lines = file($this->envPath);

        if ($lines === false) {
            throw new Exception('Cannot read env file: '.$this->envPath);
        }

        foreach ($lines as $line) {
            if (mb_strpos($line, '=', 0, 'UTF-8')) {
                $parts = array_map('trim', explode('=', $line, 2));
                if ($parts[0] && $parts[1]) {
                    $_ENV[$parts[0]] = $parts[1];
                }
            }
        }
    }
}
