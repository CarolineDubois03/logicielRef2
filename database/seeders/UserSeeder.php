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
        'login' => 'admin1234',
        'password' => Hash::make('password'),
        'id_service' => 1,
        'role' => 'admin',
    ]);

    User::factory()->create([
        'last_name' => 'Lemaitre',
        'first_name' => 'Anne',
        'email' => 'anne.lemaitre@ac.andenne.be',
        'login' => 'alemaitre',
        'password' => Hash::make('password'),
        'id_service' => 2,
        'role' => 'responsable',
    ]);

    User::factory()->create([
        'last_name' => 'Rabenda',
        'first_name' => 'Anne-Catherine',
        'email' => 'annecatherine.rabenda@ac.andenne.be',
        'login' => 'arabenda',
        'password' => Hash::make('password'),
        'id_service' => 2,
        'role' => 'responsable',
    ]);

    User::factory()->create([
        'last_name' => 'Pirsoul',
        'first_name' => 'Jerome',
        'email' => 'jerome.pirsoul@ac.andenne.be',
        'login' => 'jpirsoul',
        'password' => Hash::make('password'),
        'id_service' => 2,
        'role' => 'agent',
    ]);



        User::factory(10)->create(); // Génère 10 utilisateurs aléatoires

    }
}
