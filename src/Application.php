<?php

declare(strict_types=1);

namespace App;

use App\Contracts\CommandInterface;
use App\Enums\LogLevel;
use App\Providers\Config;
use App\Providers\Database;
use App\Providers\Logger;
use App\Providers\Router;
use Closure;
use Exception;
use InvalidArgumentException;
use SplFileInfo;
use Throwable;

final class Application extends Container
{
    public function init(): void
    {
        $this->registerServiceProviders();
        $this->bootServiceProviders();
    }

    public function registerServiceProviders(): void
    {
        $config = new Config($this);
        $providers = $config->load('providers');

        foreach ($providers as $provider) {
            $this->register($provider, fn () => new $provider($this));
        }
    }

    public function bootServiceProviders(): void
    {
        array_walk($this->instances, function (ServiceProvider $provider, string $name) {
            if (method_exists($provider, 'boot')) {
                $this->set($name, $provider);
            }
        });
    }

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
     * @param  array<string, string>  $context
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

    public function handleHttpRequest(string $method, string $uri): void
    {
        try {
            $this->router()->handle($method, $uri)->send();
        } catch (Throwable $throwable) {
            $this->log('error', $throwable->getMessage());
            $this->router()->handleException();
        }
    }

    /**
     * @param  array<int, string>  $values
     */
    public function handleConsoleCommand(array $values): void
    {
        try {
            if (empty($values)) {
                throw new Exception('Missing command.');
            }

            $items = glob(base_path('src/Commands').'/*.php', GLOB_NOSORT);
            if ($items === false) {
                throw new Exception('Commands not found.');
            }

            foreach ($items as $item) {
                $file = new SplFileInfo($item);
                if ($values[0] === $name = strtolower(str_replace('.php', '', $file->getFilename()))) {
                    $command = 'App\Commands\\'.ucfirst($name);
                    if (is_subclass_of($command, CommandInterface::class)) {
                        (new $command)->handle();
                        exit(0);
                    }
                }
            }

            throw new Exception('Command not found: '.$values[0]);
        } catch (Throwable $throwable) {
            $this->log('error', $throwable->getMessage());
            echo $throwable->getMessage();
            exit(0);
        }
    }
}
