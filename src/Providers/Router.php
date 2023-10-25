<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\HtmlResponse;
use App\Http\Response;
use App\ServiceProvider;
use Closure;

/**
 * Simple router. For production, use nikic/FastRoute.
 */
final class Router extends ServiceProvider
{
    /**
     * @var array<string, array<string, Closure>>
     */
    protected array $routes = [];

    public function addRoute(string $method, string $url, Closure $handler): void
    {
        // Add to the route map.
        $this->routes[$method][$url] = $handler;
    }

    public function handle(string $method, string $uri): Response
    {
        // Strip query string (?foo=bar) and decode URI.
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }

        $uri = rawurldecode($uri);

        if (isset($this->routes[$method], $this->routes[$method][$uri])) {
            return $this->routes[$method][$uri]();
        } else {
            return new HtmlResponse('Page not found.', 404, 'Not Found');
        }
    }

    public function handleException(): Response
    {
        return new HtmlResponse('Opsst, something went wrong.', 500, 'Internal Server Error');
    }
}
