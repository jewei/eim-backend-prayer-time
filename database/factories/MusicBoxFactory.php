<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\PrayerTimezone;
use App\Models\MusicBox;
use Illuminate\Database\Eloquent\Factories\Factory;

class MusicBoxFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = MusicBox::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'prayer_timezone' => $this->faker->randomElement(PrayerTimezone::cases()),
            'prayer_time_enabled' => true,
        ];
    }
}
