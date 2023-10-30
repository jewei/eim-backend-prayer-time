<?php

declare(strict_types=1);

namespace App\Http;

final class JsonResponse extends Response
{
    /**
     * @param  array<string, string>  $headers
     */
    public function __construct(
        protected string $content,
        protected int $statusCode,
        protected string $statusText,
        protected array $headers,
    ) {
        parent::__construct($content, $statusCode, $statusText, $headers);

        $encoded = json_encode($content);

        $this->content = \is_string($encoded) ? $encoded : '';
        $this->headers = [
            'Content-Type' => 'application/json',
        ];
    }
}
