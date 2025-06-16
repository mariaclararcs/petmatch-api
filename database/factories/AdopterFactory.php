<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AdopterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $birthDate = $this->faker->dateTimeBetween('-70 years', '-18 years')->format('Y-m-d');
        
        return [
            'id' => Str::uuid(),
            'user_id' => User::factory(),
            'name' => $this->faker->name(),
            'birth_date' => $birthDate,
            'phone' => $this->generateBrazilianPhoneNumber(),
            'address' => $this->faker->streetAddress(),
            'cep' => $this->faker->numerify('########'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

     private function generateBrazilianPhoneNumber(): string
    {
        $prefixes = ['11', '12', '13', '14', '15', '16', '17', '18', '19',
                    '21', '22', '24', '27', '28', '31', '32', '33', '34',
                    '35', '37', '38', '41', '42', '43', '44', '45', '46',
                    '47', '48', '49', '51', '53', '54', '55', '61', '62',
                    '63', '64', '65', '66', '67', '68', '69', '71', '73',
                    '74', '75', '77', '79', '81', '82', '83', '84', '85',
                    '86', '87', '88', '89', '91', '92', '93', '94', '95',
                    '96', '97', '98', '99'];
        
        $prefix = $this->faker->randomElement($prefixes);
        $number = $this->faker->numerify('#########');
        
        return "($prefix) " . substr($number, 0, 4) . '-' . substr($number, 4);
    }
}
