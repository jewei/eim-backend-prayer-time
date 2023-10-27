<?php

declare(strict_types=1);

function base_path(string $path = ''): string
{
    if ($path) {
        return __DIR__.DIRECTORY_SEPARATOR.$path;
    }

    return __DIR__;
}

function app(): App\Application
{
    return App\Application::make();
}

function now(): string
{
    return (new DateTimeImmutable('now'))->format('Y-m-d H:i:s');
}

function file_read(string $filename): string
{
    if (false === $data = file_get_contents($filename)) {
        throw new Exception('Error reading file: '.$filename);
    }

    return $data;
}

function diff_for_humans(DateTimeInterface $dateTime): string
{
    $interval = ($now = new DateTimeImmutable('now'))->diff($dateTime);
    $relativeTerm = ($dateTime > $now ? ' from now' : ' ago');

    return match (true) {
        $interval->y > 0 => $interval->y.' year'.($interval->y > 1 ? 's' : '').$relativeTerm,
        $interval->m > 0 => $interval->m.' month'.($interval->m > 1 ? 's' : '').$relativeTerm,
        $interval->d > 0 => $interval->d.' day'.($interval->d > 1 ? 's' : '').$relativeTerm,
        $interval->h > 0 => $interval->h.' hour'.($interval->h > 1 ? 's' : '').$relativeTerm,
        $interval->i > 0 => $interval->i.' minute'.($interval->i > 1 ? 's' : '').$relativeTerm,
        default => 'Just now',
    };
}

/**
 * @param  array<string, mixed>  $data
 */
function view(string $file, array $data): string
{
    if (is_file($file)) {
        extract($data);

        ob_start();

        include $file;

        $contents = ob_get_contents();

        ob_clean();

        return (string) $contents;
    }

    throw new Exception('File not found: '.$file);
}

function str_random(int $length): string
{
    return bin2hex((new Random\Randomizer())->getBytes($length));
}
