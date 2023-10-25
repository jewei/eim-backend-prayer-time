<?php

declare(strict_types=1);

namespace App\Http;

abstract class Response
{
    /**
     * @param  array<string, string>  $headers
     */
    public function __construct(
        protected string $content,
        protected int $statusCode = 200,
        protected string $statusText = 'OK',
        protected array $headers = [],
    ) {
    }

    public function send(): void
    {
        $this->sendHeaders();
        $this->sendContent();
    }

    public function sendHeaders(): void
    {
        if (headers_sent()) {
            return;
        }

        foreach ($this->headers as $name => $value) {
            header($name.': '.$value);
        }

        header(sprintf('HTTP/1.0 %s %s', $this->statusCode, $this->statusText), true, $this->statusCode);
    }

    public function sendContent(): void
    {
        echo $this->content;
    }
}
