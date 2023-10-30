<?php

declare(strict_types=1);

namespace App\Commands;

use App\Command;
use App\Enums\PrayerTimezone;
use App\PrayerTimeGateway;
use DateTimeImmutable;
use DateTimeInterface;
use Throwable;

final class Fetch extends Command
{
    private DateTimeInterface $datetime;

    /**
     * @param  array<int, string>  $arguments
     */
    public function handle(array $arguments): void
    {
        try {
            $this->datetime = $this->resolveDate($arguments);
            $this->fetchAndStoreData($this->datetime);
        } catch (Throwable $throwable) {
            $this->app->log('error', $throwable->getMessage(), ['argv' => $arguments]);

            $this->app->mailer()->send(
                'admin@email.com',
                'Fetch Prayer Time Error',
                $throwable->getMessage(),
            );

            echo $throwable->getMessage();
        }
    }

    private function fetchAndStoreData(DateTimeInterface $datetime): void
    {
        foreach (PrayerTimezone::cases() as $prayerTimezone) {
            $solatEntry = PrayerTimeGateway::fetchDailySchedule($prayerTimezone, $datetime);

            PrayerTimeGateway::upsert(
                prayerTimezone: $prayerTimezone,
                solatEntry: $solatEntry,
            );
        }
    }

    /**
     * @param  array<int, string>  $arguments
     */
    private function resolveDate(array $arguments): DateTimeInterface
    {
        $datetime = $arguments[1] ?? 'now';

        return new DateTimeImmutable($datetime);
    }
}
