<?php

declare(strict_types=1);

namespace App\Traits;

use App\Application;
use App\Providers\Config;
use App\ServiceProvider;

trait HasServiceProviders
{
    private static ?Application $app = null;

    public static function make(): self
    {
        if (! self::$app instanceof Application) {
            self::$app = (new self())->init();
        }

        return self::$app;
    }

    public function init(): self
    {
        $this->registerServiceProviders();
        $this->bootServiceProviders();

        return $this;
    }

    protected function registerServiceProviders(): void
    {
        $config = new Config($this);
        $providers = $config->load('providers');

        foreach ($providers as $provider) {
            $this->register($provider, fn (): object => new $provider($this));
        }
    }

    protected function bootServiceProviders(): void
    {
        array_walk($this->instances, function (ServiceProvider $provider, string $name): void {
            if (method_exists($provider, 'boot')) {
                $this->set($name, $provider);
            }
        });
    }
}
