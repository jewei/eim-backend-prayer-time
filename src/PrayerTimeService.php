<?php

declare(strict_types=1);

namespace App;

use App\Enums\PrayerTimezone;
use App\Enums\Waktu;
use App\Models\PrayerTime;
use Carbon\CarbonInterface;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;

/**
 * This service module handles prayer time related logic.
 */
class PrayerTimeService
{
    public const API_URL = 'https://www.e-solat.gov.my/index.php';

    /**
     * @return array<int, array<string, string>>
     */
    public function fetchWeeklySchedule(PrayerTimezone $prayerTimezone): array
    {
        $response = Http::get(self::API_URL, [
            'r' => 'esolatApi/takwimsolat',
            'period' => 'week',
            'zone' => $prayerTimezone->name,
        ]);

        if (! $response->ok() || $response->json('status') !== 'OK!') {
            throw new Exception('Error fetching weekly prayer timezone: '.$prayerTimezone->name);
        }

        return $response->json('prayerTime'); /** @phpstan-ignore-line */
    }

    /**
     * @return array<string, string>
     */
    public function fetchDailySchedule(PrayerTimezone $prayerTimezone, CarbonInterface $datetime): array
    {
        $url = self::API_URL.'?'.http_build_query([
            'r' => 'esolatApi/takwimsolat',
            'period' => 'duration',
            'zone' => $prayerTimezone->name,
        ]);

        $response = Http::asForm()->post($url, [
            'datestart' => $date = $datetime->format('Y-m-d'),
            'dateend' => $date,
        ]);

        if (! $response->ok() || $response->json('status') !== 'OK!') {
            throw new Exception('Error fetching daily prayer timezone: '.$prayerTimezone->name);
        }

        return $response->json('prayerTime')[0]; /** @phpstan-ignore-line */
    }

    public function upsert(PrayerTimezone $prayerTimezone, SolatEntry $solatEntry): void
    {
        $date = Carbon::parse($solatEntry->date);

        foreach (Waktu::cases() as $waktu) {
            $datetime = Carbon::parse(
                sprintf(
                    '%s %s',
                    $solatEntry->date,
                    $solatEntry->{$waktu->value}
                )
            );

            PrayerTime::whereDate('start_at', $date->format('Y-m-d')) /** @phpstan-ignore-line */
                ->updateOrCreate([
                    'prayer_timezone' => $prayerTimezone->name,
                    'waktu' => $waktu->value,
                ], [
                    'start_at' => $datetime,
                ]);
        }
    }
}
