<?php

declare(strict_types=1);

namespace App;

use App\Enums\PrayerTimezone;
use App\Http\HtmlResponse;
use App\Http\Response;
use DateTimeInterface;
use Exception;

/**
 * This service module handles prayer time related logic.
 */
final class PrayerTimeGateway
{
    public const API_URL = 'https://www.e-solat.gov.my/index.php';

    public function fetchWeeklySchedule(PrayerTimezone $prayerTimezone)
    {
    }

    public function fetchDailySchedule(PrayerTimezone $prayerTimezone, DateTimeInterface $datetime)
    {
    }

    public function upsert(PrayerTimezone $prayerTimezone, SolatEntry $solatEntry)
    {
    }

    public static function viewAll(): Response
    {
        $prayerTimes = Repository::getUpcomingPrayerTimes();
        $subscribers = Repository::getSubscribers();

        return new HtmlResponse(view(base_path('views/dashboard.view.php'), [
            'subscribers' => $subscribers,
            'prayerTimes' => $prayerTimes,
        ]));
    }

    public static function viewSubscriber(): Response
    {
        if (! array_key_exists('id', $_REQUEST)) {
            throw new Exception('Missing user id');
        }

        $subscriber = Repository::getSubscriber((int) $_REQUEST['id']);

        if (! $subscriber) {
            return new HtmlResponse('Subscriber not found', 404, 'Not found');
        }

        return new HtmlResponse(view(base_path('views/subscriber.view.php'), [
            'subscriber' => $subscriber,
        ]));
    }
}
