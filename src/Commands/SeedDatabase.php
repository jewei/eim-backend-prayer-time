<?php

declare(strict_types=1);

namespace App\Commands;

use App\Enums\PrayerTimezone;
use App\Models\MusicBox;
use App\Models\Song;
use App\Models\Subscriber;
use App\PrayerTimeService;
use App\SolatEntry;
use Illuminate\Console\Command;
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
        $queries = file_get_contents('database/tables.sql');

        if ($queries !== false) {
            // This operation drop the tables and recreate them. If existing
            // tables exists, they will be removed (data lost).
            DB::unprepared($queries);
        }
    }

    protected function seedDatabase(): void
    {
        // Seed prayer times.
        foreach (PrayerTimezone::cases() as $prayerTimezone) {
            $entries = $this->prayerTimeService->fetchWeeklySchedule($prayerTimezone);

            foreach ($entries as $entry) {
                $this->prayerTimeService->upsert(
                    prayerTimezone: $prayerTimezone,
                    solatEntry: SolatEntry::from($entry),
                );
            }
        }

        // Generate fake subscribers.
        Subscriber::factory()->count(10)->create();

        // Generate fake music boxes and songs.
        MusicBox::factory()
            ->has(Song::factory()->count(3))
            ->count(10)
            ->create();

        // Generate subscriptions.
        Subscriber::all()->each(function (Subscriber $subscriber) {
            $musicBoxes = MusicBox::inRandomOrder()->pluck('id');

            $subscriber->subscriptions()->createMany([
                ['music_box_id' => $musicBoxes->first()],
                ['music_box_id' => $musicBoxes->last()],
            ]);
        });
    }
}
