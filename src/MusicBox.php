<?php

declare(strict_types=1);

namespace App;

use App\Enums\PrayerTimezone;
use DateTime;

final readonly class MusicBox
{
    /**
     * @param  array<int, Song>  $songs
     */
    public function __construct(
        public int $id,
        public PrayerTimezone $timezone,
        public bool $prayer_time_enabled,
        public DateTime $created,
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
            PrayerTimezone::from($data['prayer_timezone']),
            (bool) $data['prayer_time_enabled'],
            new DateTime((string) $data['created_at']),
            Repository::getSongsByAlbum((int) $data['id']),
        );
    }
}
