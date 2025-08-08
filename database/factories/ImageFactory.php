<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => (string) Str::uuid(),
            'slug' => Str::random(7),
            'user_id' => User::factory(),
            'type' => 'image',
            'filename' => Str::random(40) . '.png',
            'original_name' => fake()->word() . '.png',
            'mime' => 'image/png',
            'size' => fake()->numberBetween(1000, 500000),
            'is_public' => fake()->boolean(),
        ];
    }
}
