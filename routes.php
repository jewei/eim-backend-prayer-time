<?php

declare(strict_types=1);

use App\PrayerTimeGateway;

$app->route('GET', '/', fn () => PrayerTimeGateway::viewAll());

$app->route('GET', '/subscriber', fn () => PrayerTimeGateway::viewSubscriber());
