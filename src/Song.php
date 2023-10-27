<?php

declare(strict_types=1);

namespace App;

use DateTimeImmutable;
use DateTimeInterface;

final readonly class Song
{
    public function __construct(
        public int $id,
        public int $music_box_id,
        public string $name,
        public string $file,
        public DateTimeInterface $created,
    ) {
    }

    /**
     * @param  array<string, int|string>  $data
     */
    public static function fromArray(array $data): self
    {
        return new self(
            (int) $data['id'],
            (int) $data['music_box_id'],
            (string) $data['name'],
            (string) $data['filepath'],
            new DateTimeImmutable((string) $data['created_at']),
        );
    }
}
