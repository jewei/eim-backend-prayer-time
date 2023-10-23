<?php

declare(strict_types=1);

namespace App\Commands;

use App\Enums\PrayerTimezone;
use App\PrayerTimeService;
use App\SolatEntry;
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
        $date = Carbon::now()->addDays(7);

        foreach (PrayerTimezone::cases() as $prayerTimezone) {
            $schedule = $this->prayerTimeService->fetchDailySchedule($prayerTimezone, $date);

            $this->prayerTimeService->upsert(
                prayerTimezone: $prayerTimezone,
                solatEntry: SolatEntry::from($schedule),
            );
        }
    }
}
