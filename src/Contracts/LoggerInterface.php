<?php

declare(strict_types=1);

namespace App\Contracts;

use Stringable;

/**
 * To be compatible with PSR-3: Logger Interface
 */
interface LoggerInterface
{
    /**
     * System is unusable.
     *
     * @param  array<mixed, mixed>  $context
     */
    public function emergency(string|Stringable $message, array $context = []): void;

    /**
     * Action must be taken immediately.
     *
     * Example: Entire website down, database unavailable, etc. This should
     * trigger the SMS alerts and wake you up.
     *
     * @param  array<mixed, mixed>  $context
     */
    public function alert(string|Stringable $message, array $context = []): void;

    /**
     * Critical conditions.
     *
     * Example: Application component unavailable, unexpected exception.
     *
     * @param  array<mixed, mixed>  $context
     */
    public function critical(string|Stringable $message, array $context = []): void;

    /**
     * Runtime errors that do not require immediate action but should typically
     * be logged and monitored.
     *
     * @param  array<mixed, mixed>  $context
     */
    public function error(string|Stringable $message, array $context = []): void;

    /**
     * Exceptional occurrences that are not errors.
     *
     * Example: Use of deprecated APIs, poor use of an API, undesirable things
     * that are not necessarily wrong.
     *
     * @param  array<mixed, mixed>  $context
     */
    public function warning(string|Stringable $message, array $context = []): void;

    /**
     * Normal but significant events.
     *
     * @param  array<mixed, mixed>  $context
     */
    public function notice(string|Stringable $message, array $context = []): void;

    /**
     * Interesting events.
     *
     * Example: User logs in, SQL logs.
     *
     * @param  array<mixed, mixed>  $context
     */
    public function info(string|Stringable $message, array $context = []): void;

    /**
     * Detailed debug information.
     *
     * @param  array<mixed, mixed>  $context
     */
    public function debug(string|Stringable $message, array $context = []): void;

    /**
     * Logs with an arbitrary level.
     *
     * @param  mixed  $level
     * @param  array<mixed, mixed>  $context
     */
    public function log($level, string|Stringable $message, array $context = []): void;
}
