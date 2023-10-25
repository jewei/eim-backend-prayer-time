<?php

declare(strict_types=1);

namespace App\Enums;

enum LogLevel: string
{
    case EMERGENCY = 'emergency';
    case ALERT = 'alert';
    case CRITICAL = 'critical';
    case ERROR = 'error';
    case WARNING = 'warning';
    case NOTICE = 'notice';
    case INFO = 'info';
    case DEBUG = 'debug';

    /**
     * @return array<int, string>
     */
    public static function list(): array
    {
        return array_map(
            fn (self $level) => $level->value,
            self::cases()
        );
    }
}
