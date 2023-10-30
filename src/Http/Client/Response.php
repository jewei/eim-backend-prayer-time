<?php

declare(strict_types=1);

namespace App\Http\Client;

/**
 * The HTTP response object.
 */
final class Response
{
    public function __construct(
        protected int $code,
        protected string $header,
        protected string $body,
    ) {
    }

    public static function make(int $code, string $header, string $body): self
    {
        return new self($code, $header, $body);
    }

    public function getStatusCode(): int
    {
        return $this->code;
    }

    public function getContent(): string
    {
        return $this->body;
    }

    public function getJsonContent(string $key = ''): mixed
    {
        $decoded = json_decode($this->body, true);

        if ($key && \is_array($decoded) && \array_key_exists($key, $decoded)) {
            return $decoded[$key] ?? null;
        }

        return $decoded ?? null;
    }

    /**
     * @return array<string, array<int, string|null>|string|null>
     */
    public function getHeaders(): array
    {
        $lines = explode(PHP_EOL, $this->header);
        array_shift($lines); // Remove the HTTP code line.
        $lines = array_filter($lines, 'trim');

        $headers = [];

        foreach ($lines as $line) {
            $parts = explode(':', $line, 2);
            $parts = array_map('trim', $parts);
            if (\array_key_exists($parts[0], $headers)) {
                if (! \is_array($headers[$parts[0]])) {
                    $previous = $headers[$parts[0]];
                    $headers[$parts[0]] = [$previous];
                }
                /** @phpstan-ignore-next-line */
                $headers[$parts[0]][] = isset($parts[1]) ? $parts[1] : null;
            } else {
                $headers[$parts[0]] = isset($parts[1]) ? $parts[1] : null;
            }
        }

        return $headers;
    }
}
