<?php

namespace Database\Seeders;

use App\Models\Adopter;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            OngSeeder::class,
            AnimalSeeder::class,
            AdministratorSeeder::class,
            AdopterSeeder::class,
            AdoptionSeeder::class,
        ]);
    }
}
