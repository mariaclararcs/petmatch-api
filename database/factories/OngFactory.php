<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ong>
 */
class OngFactory extends Factory
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
            'user_id' => User::factory(),
            'name_institution' => $this->faker->company(),
            'document_responsible' => $this->faker->numerify('###########'),
            'cnpj' => $this->faker->numerify('###########'),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->streetAddress(),
            'cep' => $this->faker->numerify('########'),
            'description' => $this->faker->text(200),
            'ong_image' => 'https://ui-avatars.com/api/?name=' . urlencode(fake()->name) . '&color=7F9CF5&background=EBF4FF',
            'status' => $this->faker->randomElement(['approved', 'rejected', 'pending']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
