<?php

declare(strict_types=1);

namespace App\Enums;

enum Waktu: string
{
    case Imsak = 'imsak';
    case Fajr = 'fajr';
    case Syuruk = 'syuruk';
    case Dhuhr = 'dhuhr';
    case Asr = 'asr';
    case Maghrib = 'maghrib';
    case Isha = 'isha';
}
