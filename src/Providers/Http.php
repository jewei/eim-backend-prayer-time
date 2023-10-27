<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Client\Client;
use App\Http\Client\Response;
use App\ServiceProvider;

/**
 * Simple Http Client.
 */
final class Http extends ServiceProvider
{
    /**
     * @param  array<string, string>  $payload
     * @param  array<string, string>  $headers
     */
    public function request(string $method, string $url, array $payload = [], array $headers = []): Response
    {
        return (new Client())->request($method, $url, $payload, $headers);
    }
}
