<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            ServiceSeeder::class,
            CategorySeeder::class,
            RecipientSeeder::class,
            YearSeeder::class,
            UserSeeder::class,
            CourierSeeder::class,
            
        ]);
    }
}
