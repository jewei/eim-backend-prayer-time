<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\MusicBox;
use App\Models\Song;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class SongFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Song::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'music_box_id' => MusicBox::factory(),
            'name' => $this->faker->words(6, true),
            'filepath' => Str::random().'.mp3',
        ];
    }
}
