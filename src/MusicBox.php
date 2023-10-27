<?php

declare(strict_types=1);

namespace App;

use App\Enums\PrayerTimezone;
use DateTimeImmutable;
use DateTimeInterface;

final readonly class MusicBox
{
    /**
     * @param  array<int, Song>  $songs
     */
    public function __construct(
        public int $id,
        public string $name,
        public PrayerTimezone $timezone,
        public bool $prayer_time_enabled,
        public DateTimeInterface $created,
        public array $songs,
    ) {
    }

    /**
     * @param  array<string, int|string>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (int) $data['id'],
            (string) $data['name'],
            PrayerTimezone::from($data['prayer_timezone']),
            (bool) $data['prayer_time_enabled'],
            new DateTimeImmutable((string) $data['created_at']),
            Repository::getSongsByAlbum((int) $data['id']),
        );
    }
}
