<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PrayerTimezone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method static \Illuminate\Database\Query\Builder inRandomOrder($seed = '')
 *
 * @property bool $prayer_time_enabled
 */
class MusicBox extends Model
{
    use HasFactory;

    /**
     * @var array<string>|bool
     */
    protected $guarded = [];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'prayer_timezone' => PrayerTimezone::class,
    ];

    public function songs(): HasMany
    {
        return $this->hasMany(Song::class);
    }

    public function isPrayerTimeEnabled(): bool
    {
        return $this->prayer_time_enabled;
    }
}
