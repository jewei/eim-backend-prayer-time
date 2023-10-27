<?php

declare(strict_types=1);

namespace App;

use App\Enums\PrayerTimezone;
use App\Enums\Waktu;
use DateTimeImmutable;
use DateTimeInterface;

final readonly class PrayerTime
{
    public function __construct(
        public int $id,
        public PrayerTimezone $timezone,
        public Waktu $waktu,
        public DateTimeInterface $start,
    ) {
    }

    /**
     * @param  array<string, int|string>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (int) $data['id'],
            PrayerTimezone::from($data['prayer_timezone']),
            Waktu::from($data['waktu']),
            new DateTimeImmutable((string) $data['start_at']),
        );
    }
}
