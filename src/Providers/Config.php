<?php

declare(strict_types=1);

namespace App\Providers;

use App\ServiceProvider;

final class Config extends ServiceProvider
{
    /**
     * @var array<string, mixed>
     */
    protected array $storage = [];

    public function get(string $key): ?string
    {
        return \is_string($value = $this->storage()[$key])
            ? $value
            : null;
    }

    /**
     * @return array<string, string>
     */
    public function load(string $key): array
    {
        return \is_array($value = $this->storage()[$key])
            ? $value
            : [];
    }

    /**
     * @return array<string, mixed>
     */
    public function storage(): array
    {
        static $storage;

        if (! isset($storage)) {
            $storage = require base_path('config.php');
        }

        return $storage;
    }
}
