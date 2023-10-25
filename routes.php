<?php

declare(strict_types=1);

use App\Http\HtmlResponse;

$app->route('GET', '/', fn () => new HtmlResponse(json_encode(['foo' => 'bar']), 200, 'OK', ['Content-Type' => 'application/json']));

$app->route('GET', '/dashboard', fn () => new HtmlResponse('Hello world :D'));
