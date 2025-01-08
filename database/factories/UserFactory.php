<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    protected $model = \App\Models\User::class;

    public function definition()
    {
        return [
            'last_name' => $this->faker->lastName,
            'first_name' => $this->faker->firstName,
            'email' => $this->faker->unique()->safeEmail,
            'login' => $this->faker->userName,
            'password' => bcrypt('password'), // Mot de passe par défaut
            'id_service' => null, // Peut être mis à jour dans un seeder si nécessaire
            'role' => $this->faker->randomElement(['user', 'admin']), // Exemple de rôle
        ];
    }
}
