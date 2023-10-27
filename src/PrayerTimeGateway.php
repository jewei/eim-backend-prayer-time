<?php

declare(strict_types=1);

namespace App;

use App\Enums\PrayerTimezone;
use App\Enums\Waktu;
use App\Http\Client\Client;
use App\Http\HtmlResponse;
use App\Http\Response as HttpResponse;
use DateTimeImmutable;
use DateTimeInterface;
use Exception;

/**
 * This service module handles prayer time related logic.
 */
final class PrayerTimeGateway
{
    public const API_URL = 'https://www.e-solat.gov.my/index.php';

    /**
     * @return array<int, SolatEntry>
     */
    public static function fetchWeeklySchedule(PrayerTimezone $prayerTimezone): array
    {
        $url = self::API_URL.'?'.http_build_query([
            'r' => 'esolatApi/takwimsolat',
            'period' => 'week',
            'zone' => $prayerTimezone->name,
        ]);

        $response = (new Client())->request('GET', $url);

        $debugInfo = 'Zone: '.$prayerTimezone->name;

        if ($response->getStatusCode() !== 200) {
            throw new Exception('Failed to fetch daily solat times from api. '.$debugInfo);
        }

        $entries = $response->getJsonContent('prayerTime');

        if (! is_array($entries) || ! is_array($entries[0])) {
            throw new Exception('Failed to parse solat times. '.$debugInfo);
        }

        $solatEntries = [];

        foreach ($entries as $entry) {
            $solatEntries[] = SolatEntry::from($entry);
        }

        return $solatEntries;
    }

    public static function fetchDailySchedule(PrayerTimezone $prayerTimezone, DateTimeInterface $datetime): SolatEntry
    {
        $url = self::API_URL.'?'.http_build_query([
            'r' => 'esolatApi/takwimsolat',
            'period' => 'duration',
            'zone' => $prayerTimezone->name,
        ]);

        $payload = [
            'datestart' => $date = $datetime->format('Y-m-d'),
            'dateend' => $date,
        ];

        $headers = [
            'Content-Type' => 'application/x-www-form-urlencoded',
        ];

        $response = (new Client())->request('POST', $url, $payload, $headers);

        $debugInfo = 'Zone: '.$prayerTimezone->name.' Date: '.$date;

        if ($response->getStatusCode() !== 200) {
            throw new Exception('Failed to fetch weekly solat times from api. '.$debugInfo);
        }

        $entries = $response->getJsonContent('prayerTime');

        if (! is_array($entries) || ! is_array($entries[0])) {
            throw new Exception('Failed to parse solat times. '.$debugInfo);
        }

        return SolatEntry::from($entries[0]);
    }

    public static function upsert(PrayerTimezone $prayerTimezone, SolatEntry $solatEntry): void
    {
        foreach (Waktu::cases() as $waktu) {
            if ($solatEntry->{$waktu->value}) {
                $datetime = new DateTimeImmutable(sprintf('%s %s', $solatEntry->date, $solatEntry->{$waktu->value}));
                Repository::upsertPrayerTime(
                    $prayerTimezone->value,
                    $waktu->value,
                    $datetime->format('Y-m-d H:i:s'),
                );
            }
        }
    }

    public static function viewAll(): HttpResponse
    {
        $prayerTimes = Repository::getUpcomingPrayerTimes();
        $subscribers = Repository::getSubscribers();

        return new HtmlResponse(view(base_path('views/dashboard.view.php'), [
            'subscribers' => $subscribers,
            'prayerTimes' => $prayerTimes,
        ]));
    }

    public static function viewSubscriber(): HttpResponse
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
