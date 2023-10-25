<?php

declare(strict_types=1);

namespace App\Providers;

use App\Contracts\LoggerInterface;
use App\ServiceProvider;
use InvalidArgumentException;
use Stringable;
use Throwable;

final class Logger extends ServiceProvider implements LoggerInterface
{
    public function emergency(string|Stringable $message, array $context = []): void
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    public function alert(string|Stringable $message, array $context = []): void
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    public function critical(string|Stringable $message, array $context = []): void
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    public function error(string|Stringable $message, array $context = []): void
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    public function warning(string|Stringable $message, array $context = []): void
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    public function notice(string|Stringable $message, array $context = []): void
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    public function info(string|Stringable $message, array $context = []): void
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    public function debug(string|Stringable $message, array $context = []): void
    {
        $this->writeLog(__FUNCTION__, $message, $context);
    }

    /**
     * @param  string  $level
     */
    public function log($level, string|Stringable $message, array $context = []): void
    {
        $this->writeLog($level, $message, $context);
    }

    /**
     * @param  array<mixed, mixed>  $context
     */
    public function writeLog(string $level, string|Stringable $message, array $context = []): void
    {
        try {
            $logEntry = sprintf(
                '[%s] [%s] %s %s'.PHP_EOL,
                date('Y-m-d H:i:s'),
                strtoupper($level),
                $message,
                json_encode($context, JSON_PRETTY_PRINT),
            );

            file_put_contents(base_path('app.log'), $logEntry, FILE_APPEND);
        } catch (Throwable $th) {
            throw new InvalidArgumentException($th->getMessage());
        }

    }
}
