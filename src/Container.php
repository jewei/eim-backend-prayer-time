<?php

declare(strict_types=1);

namespace App;

use App\Contracts\ContainerInterface;
use App\Exceptions\EntryNotFoundException;
use Closure;

/**
 * A simple dependency injection container implementation.
 */
abstract class Container implements ContainerInterface
{
    /**
     * @var array<string, ServiceProvider>
     */
    protected $instances = [];

    /**
     * Register an object in the container.
     */
    public function register(string $abstract, Closure $concrete): void
    {
        $this->instances[$abstract] = $this->resolve($concrete);
    }

    /**
     * Directly set the object instance.
     */
    public function set(string $abstract, ServiceProvider $provider): void
    {
        $this->instances[$abstract] = $provider;
    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     */
    public function get(string $abstract): mixed
    {
        if (! $this->has($abstract)) {
            throw new EntryNotFoundException('No entry found for '.$abstract);
        }

        return $this->instances[$abstract];
    }

    /**
     * Determine if the container has the entry by the given identifier.
     */
    public function has(string $abstract): bool
    {
        return array_key_exists($abstract, $this->instances);
    }

    /**
     * Resolve a concrete instance.
     */
    public function resolve(Closure $concrete): ServiceProvider
    {
        return $concrete($this);
    }
}
