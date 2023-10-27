<?php

declare(strict_types=1);

namespace App;

use DateTimeImmutable;
use DateTimeInterface;

final readonly class Subscriber
{
    /**
     * @param  array<int, MusicBox>  $subscriptions
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public DateTimeInterface $created,
        public array $subscriptions,
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
            (string) $data['email'],
            new DateTimeImmutable((string) $data['created_at']),
            Repository::getSubscriptions((int) $data['id']),
        );
    }
}
