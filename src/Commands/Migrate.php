<?php

declare(strict_types=1);

namespace App\Commands;

use App\Command;
use App\Enums\PrayerTimezone;
use App\PrayerTimeGateway;
use App\Repository;

final class Migrate extends Command
{
    /**
     * @param  array<int, string>  $arguments
     */
    public function handle(array $arguments): void
    {
        in_array('--fast', $arguments)
            ? $this->fast()
            : $this->normal();
    }

    private function normal(): void
    {
        $this->app->db()->executeRaw(
            file_read(base_path('database/tables.sql'))
        );

        // Populate prayer_times.
        foreach (PrayerTimezone::cases() as $prayerTimezone) {
            $solatEntries = PrayerTimeGateway::fetchWeeklySchedule($prayerTimezone);

            foreach ($solatEntries as $solatEntry) {
                PrayerTimeGateway::upsert(
                    prayerTimezone: $prayerTimezone,
                    solatEntry: $solatEntry,
                );
            }
        }

        // Populate subscribers.
        for ($i = 0; $i < 10; $i++) {
            Repository::createSubscriber(
                $name = str_random(8),
                $name.'@example.com',
                'secret',
            );
        }

        // Populate music boxes and songs.
        $musicBoxIndex = 1;
        foreach (PrayerTimezone::cases() as $zone) {
            Repository::createMusicBox(
                $name = str_random(8),
                $zone->value,
                random_int(0, 1) ? true : false,
            );

            for ($i = 0; $i < 3; $i++) {
                Repository::createSong(
                    $musicBoxIndex++,
                    $name = str_random(8),
                    $name.'.mp3',
                );
            }
        }

        // Populate subscriptions.
        $musicBoxes = Repository::findSubscribableMusicBoxes();
        foreach ($musicBoxes as $musicBox) {
            Repository::createSubscription(random_int(1, 10), $musicBox->id);
            Repository::createSubscription(random_int(1, 10), $musicBox->id);
            Repository::createSubscription(random_int(1, 10), $musicBox->id);
        }

        echo 'Migration succsess';
    }

    private function fast(): void
    {
        $this->app->db()->executeRaw(
            file_read(base_path('database/tables.sql'))
        );

        $this->app->db()->executeRaw(
            file_read(base_path('database/sample-data.sql'))
        );

        echo 'Migration succsess (fast)';
    }
}
