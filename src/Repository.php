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
}
