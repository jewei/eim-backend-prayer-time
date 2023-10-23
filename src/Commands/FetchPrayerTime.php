<?php

declare(strict_types=1);

namespace App\Commands;

use App\Enums\PrayerTimezone;
use App\Enums\Waktu;
use App\Models\PrayerTime;
use App\PrayerTimeService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class FetchPrayerTime extends Command
{
    protected $signature = 'app:fetch-prayer-time';

    protected $description = 'Import prayer time';

    public function __construct(protected PrayerTimeService $prayerTimeService)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        foreach (PrayerTimezone::cases() as $prayerTimezone) {
            $date = Carbon::now()->addDays(8);
            $entry = $this->prayerTimeService->fetchDailySchedule($prayerTimezone, $date);

            foreach (Waktu::cases() as $waktu) {
                if (array_key_exists($waktu->value, $entry)) {
                    PrayerTime::updateOrCreate([
                        'prayer_timezone' => $prayerTimezone->name,
                        'waktu' => $waktu->value,
                    ], [
                        'start_at' => Carbon::parse($entry['date'].' '.$entry[$waktu->value]),
                    ]);
                }
            }
        }
    }
}
