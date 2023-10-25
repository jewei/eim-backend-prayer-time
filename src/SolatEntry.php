<?php

declare(strict_types=1);

namespace App;

/**
 * Value object for a solat time entry item return by API from
 * https://www.e-solat.gov.my/ consist of daily prayer schedule.
 */
final readonly class SolatEntry
{
    public function __construct(
        public string $hijri,
        public string $date,
        public string $day,
        public string $imsak,
        public string $fajr,
        public string $syuruk,
        public string $dhuhr,
        public string $asr,
        public string $maghrib,
        public string $isha,
    ) {
    }

    /**
     * @param  array<string, string>  $item
     */
    public static function from(array $item): self
    {
        return new self(
            $item['hijri'],
            $item['date'],
            $item['day'],
            $item['imsak'],
            $item['fajr'],
            $item['syuruk'],
            $item['dhuhr'],
            $item['asr'],
            $item['maghrib'],
            $item['isha'],
        );
    }
}
