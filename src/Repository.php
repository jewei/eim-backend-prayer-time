<?php

declare(strict_types=1);

namespace App;

/**
 * This service module handles prayer time related logic.
 */
final class Repository
{
    /**
     * @return array<int, Subscriber>
     */
    public static function getSubscribers(): array
    {
        $query = <<<'QUERY'
            SELECT
                *
            FROM
                subscribers
            ORDER BY
                id DESC
            LIMIT 20 OFFSET 0
        QUERY;

        $rows = app()->db()->fetch($query);

        $subscribers = [];

        foreach ($rows as $row) {
            $subscribers[] = Subscriber::fromArray($row);
        }

        return $subscribers;
    }

    public static function getSubscriber(int $id): ?Subscriber
    {
        $rows = app()->db()->fetch(<<<'QUERY'
            SELECT
                *
            FROM
                subscribers
            WHERE
                id = :id
            LIMIT 1
        QUERY, [':id' => $id]);

        if (empty($rows)) {
            return null;
        }

        return Subscriber::fromArray($rows[0]);
    }

    /**
     * @return array<int, MusicBox>
     */
    public static function getSubscriptions(int $userId): array
    {
        $rows = app()->db()->fetch(<<<'QUERY'
            SELECT
                *
            FROM
                music_boxes mb
                LEFT JOIN subscriptions s ON s.music_box_id = mb.id
            WHERE
                s.subscriber_id = :id
        QUERY, [':id' => $userId]);

        $subscriptions = [];

        foreach ($rows as $row) {
            $subscriptions[] = MusicBox::fromArray($row);
        }

        return $subscriptions;
    }

    /**
     * @return array<int, PrayerTime>
     */
    public static function getUpcomingPrayerTimes(): array
    {
        $query = <<<'QUERY'
            SELECT
                *
            FROM
                prayer_times
            WHERE
                start_at > :now
            ORDER BY
                start_at ASC
            LIMIT 20 OFFSET 0
        QUERY;

        $rows = app()->db()->fetch($query, [':now' => now()]);

        $prayerTimes = [];

        foreach ($rows as $row) {
            $prayerTimes[] = PrayerTime::fromArray($row);
        }

        return $prayerTimes;
    }

    public static function getSong(int $id): ?Song
    {
        $rows = app()->db()->fetch(<<<'QUERY'
            SELECT
                *
            FROM
                songs
            WHERE
                id = :id
            LIMIT 1
        QUERY, [':id' => $id]);

        return count($rows) > 0
            ? Song::fromArray($rows[0])
            : null;
    }

    /**
     * @param  array<int, int>  $ids
     * @return array<int, Song>
     */
    public static function getSongs(array $ids): array
    {
        if (count($ids) < 1) {
            return [];
        }

        $in = implode(',', array_fill(0, count($ids), '?'));

        $rows = app()->db()->fetch(<<<QUERY
            SELECT
                *
            FROM
                songs
            WHERE
                id IN( $in )
        QUERY, $ids);

        $songs = [];

        foreach ($rows as $row) {
            $songs[] = Song::fromArray($row);
        }

        return $songs;
    }

    /**
     * @return array<int, Song>
     */
    public static function getSongsByAlbum(int $id): array
    {
        $rows = app()->db()->fetch(<<<'QUERY'
            SELECT
                s.*
            FROM
                songs s
                INNER JOIN music_boxes mb ON mb.id = s.music_box_id
            WHERE
                mb.id = :id;
        QUERY, [':id' => $id]);

        $songs = [];

        foreach ($rows as $row) {
            $songs[] = Song::fromArray($row);
        }

        return $songs;
    }

    public static function upsertPrayerTime(string $timezone, string $waktu, string $start): int
    {
        // This is the SQLite version of `ON DUPLICATE KEY UPDATE`.
        $query = <<<'QUERY'
            INSERT INTO prayer_times (prayer_timezone, waktu, start_at, created_at, updated_at)
                VALUES(:timezone, :waktu, :start, :now, :now) ON CONFLICT (prayer_timezone, waktu, DATE(start_at))
                DO
                UPDATE
                SET
                    start_at = excluded.start_at,
                    updated_at = excluded.created_at;
        QUERY;

        $result = app()->db()->execute($query, [
            ':timezone' => $timezone,
            ':waktu' => $waktu,
            ':start' => $start,
            ':now' => now(),
        ]);

        return is_int($result) ? $result : 0;
    }

    public static function createSubscriber(string $name, string $email, #[\SensitiveParameter] string $password): int
    {
        $query = <<<'QUERY'
            INSERT INTO subscribers (name, email, PASSWORD, created_at, updated_at)
                VALUES(:name, :email, :password, :now, :now);
        QUERY;

        $result = app()->db()->execute($query, [
            ':name' => $name,
            ':email' => $email,
            ':password' => password_hash($password, PASSWORD_BCRYPT),
            ':now' => now(),
        ]);

        return is_int($result) ? $result : 0;
    }

    public static function createMusicBox(string $name, string $timezone, bool $prayerTimeEnabled): int
    {
        $query = <<<'QUERY'
            INSERT INTO music_boxes (name, prayer_timezone, prayer_time_enabled, created_at, updated_at)
                VALUES(:name, :timezone, :enabled, :now, :now);
        QUERY;

        $result = app()->db()->execute($query, [
            ':name' => $name,
            ':timezone' => $timezone,
            ':enabled' => $prayerTimeEnabled ? 1 : 0,
            ':now' => now(),
        ]);

        return is_int($result) ? $result : 0;
    }

    /**
     * @return array<int, MusicBox>
     */
    public static function findSubscribableMusicBoxes(): array
    {
        $rows = app()->db()->fetch(<<<'QUERY'
            SELECT
                *
            FROM
                music_boxes
            WHERE
                prayer_time_enabled = 1
        QUERY);

        $musicBoxes = [];

        foreach ($rows as $row) {
            $musicBoxes[] = MusicBox::fromArray($row);
        }

        return $musicBoxes;
    }

    public static function createSong(int $musicBoxId, string $name, string $filepath): int
    {
        $query = <<<'QUERY'
            INSERT INTO songs (music_box_id, name, filepath, created_at, updated_at)
                VALUES(:id, :name, :filepath, :now, :now);
        QUERY;

        $result = app()->db()->execute($query, [
            ':id' => $musicBoxId,
            ':name' => $name,
            ':filepath' => $filepath,
            ':now' => now(),
        ]);

        return is_int($result) ? $result : 0;
    }

    public static function createSubscription(int $subscriberId, int $musicBoxId): int
    {
        $query = <<<'QUERY'
            INSERT INTO subscriptions (subscriber_id, music_box_id, created_at, updated_at)
                VALUES(:subscriber_id, :music_box_id, :now, :now) ON CONFLICT (subscriber_id, music_box_id)
                DO
                UPDATE
                SET
                    updated_at = excluded.created_at;
        QUERY;

        $result = app()->db()->execute($query, [
            ':subscriber_id' => $subscriberId,
            ':music_box_id' => $musicBoxId,
            ':now' => now(),
        ]);

        return is_int($result) ? $result : 0;
    }
}
