<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PrayerTimezone;
use App\Enums\Waktu;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static \Illuminate\Database\Eloquent\Builder create(array $attributes = [])
 * @method static \Illuminate\Database\Eloquent\Builder updateOrCreate(array $attributes, array $values = [])
 * @method static \Illuminate\Database\Query\Builder whereDate($column, $operator, $value = null, $boolean = 'and')
 * @method static \Illuminate\Database\Eloquent\Builder updateOrCreate(array $attributes, array $values = [])
 */
class PrayerTime extends Model
{
    /**
     * @var array<string>|bool
     */
    protected $guarded = [];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'prayer_timezone' => PrayerTimezone::class,
        'waktu' => Waktu::class,
        'start_at' => 'datetime',
    ];
}
