<?php

declare(strict_types=1);

namespace App;

use App\Enums\PrayerTimezone;
use DateTimeInterface;

/**
 * This service module handles prayer time related logic.
 */
class PrayerTimeService
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

    public static function viewAll()
    {
    }

    public static function viewSubscriber(int $id)
    {
    }
}
