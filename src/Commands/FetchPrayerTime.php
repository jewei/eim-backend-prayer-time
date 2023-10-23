<?php

declare(strict_types=1);

namespace App\Commands;

use App\Enums\PrayerTimezone;
use App\FetchErrorMail;
use App\PrayerTimeService;
use App\SolatEntry;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Throwable;

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

        try {
            foreach (PrayerTimezone::cases() as $prayerTimezone) {
                $schedule = $this->prayerTimeService->fetchDailySchedule($prayerTimezone, $date);

                $this->prayerTimeService->upsert(
                    prayerTimezone: $prayerTimezone,
                    solatEntry: SolatEntry::from($schedule),
                );
            }
        } catch (Throwable $th) {
            Mail::to('admin@email.com')->send(new FetchErrorMail($th->getMessage()));
            throw $th;
        }
    }
}
