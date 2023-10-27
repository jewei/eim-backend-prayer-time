<?php

declare(strict_types=1);

namespace App\Traits;

use App\Enums\LogLevel;
use App\Providers\Config;
use App\Providers\Database;
use App\Providers\Logger;
use App\Providers\Mailer;
use App\Providers\Router;
use Closure;
use InvalidArgumentException;

trait HasMacros
{
    public function config(string $key): ?string
    {
        /** @var Config */
        $config = $this->get(Config::class);

        return $config->get($key);
    }

    /**
     * @return array<string, string>
     */
    public function configs(string $key): array
    {
        /** @var Config */
        $config = $this->get(Config::class);

        return $config->load($key);
    }

    /**
     * @param  array<string, mixed>  $context
     */
    public function log(string $level, string $message, array $context = []): void
    {
        /** @var Logger */
        $logger = $this->get(Logger::class);

        if (! in_array($level, LogLevel::list())) {
            throw new InvalidArgumentException('Invalid log level: '.$level);
        }

        $logger->{$level}($message, $context);
    }

    public function db(): Database
    {
        /** @var Database */
        return $this->get(Database::class);
    }

    public function router(): Router
    {
        /** @var Router */
        return $this->get(Router::class);
    }

    public function route(string $method, string $url, Closure $handler): void
    {
        $this->router()->addRoute($method, $url, $handler);
    }

    public function mailer(): Mailer
    {
        /** @var Mailer */
        return $this->get(Mailer::class);
    }
}
