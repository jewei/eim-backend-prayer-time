<?php

declare(strict_types=1);

namespace App\Commands;

use App\Enums\PrayerTimezone;
use App\Enums\Waktu;
use App\Models\PrayerTime;
use App\PrayerTimeService;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SeedDatabase extends Command
{
    protected $signature = 'app:seed-database';

    protected $description = 'Create tables and seed data';

    public function __construct(protected PrayerTimeService $prayerTimeService)
    {
        parent::__construct();
    }

    public function handle(): void
    {
        $this->createTables();
        $this->seedDatabase();
    }

    protected function createTables(): void
    {
        $queries = file_get_contents('database/seeder.sql');

        if ($queries !== false) {
            DB::unprepared($queries);
        }
    }

    protected function seedDatabase(): void
    {
        foreach (PrayerTimezone::cases() as $prayerTimezone) {
            $entries = $this->prayerTimeService->fetchWeeklySchedule($prayerTimezone);

            foreach ($entries as $entry) {
                foreach (Waktu::cases() as $waktu) {
                    if (array_key_exists($waktu->value, $entry)) {
                        PrayerTime::create([
                            'prayer_timezone' => $prayerTimezone,
                            'waktu' => $waktu,
                            'start_at' => Carbon::parse($entry['date'].' '.$entry[$waktu->value]),
                        ]);
                    }
                }
            }
        }
    }
}
