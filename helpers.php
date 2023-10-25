<?php

declare(strict_types=1);

function base_path(string $path = ''): string
{
    if ($path) {
        return __DIR__.DIRECTORY_SEPARATOR.$path;
    }

    return __DIR__;
}
