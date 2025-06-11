<?php

namespace Database\Factories;

use App\Models\Ong;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Animal>
 */
class AnimalFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid(),
            'ong_id' => Ong::factory(),
            'name' => $this->faker->firstName(),
            'age' => $this->faker->numberBetween(0, 20),
            'gender' => $this->faker->randomElement(['male', 'female']),
            'type' => $this->faker->randomElement(['dog', 'cat', 'other']),
            'size' => $this->faker->randomElement(['small', 'medium', 'large']),
            'shelter_date' => $this->faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
            'image' => 'https://www.upload.ee/image/17942234/a323060aa972785ea02543d0f2003554.jpg',
            'description' => 'description for animal',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
