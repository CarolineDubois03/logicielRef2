<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::factory()->create([
            'last_name' => 'Admin',
            'first_name' => 'User',
            'email' => 'admin@example.com',
            'login' => 'admin',
            'password' => Hash::make('password'),
            'id_service' => 1,
        ]);

        User::factory(10)->create(); // Génère 10 utilisateurs aléatoires
    }
}
