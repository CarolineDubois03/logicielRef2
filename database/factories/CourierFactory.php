<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;
use App\Models\User;
use App\Models\Recipient;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Courier>
 */
class CourierFactory extends Factory
{
    protected $model = \App\Models\Courier::class;

    public function definition()
    {
        return [
            'object' => $this->faker->sentence, // Objet du courrier
            'annual_id' => $this->faker->unique()->numberBetween(1, 1000), // Numéro annuel
            'id_handling_user' => User::inRandomOrder()->first()?->id ?? User::factory(), // Utilisateur existant ou factory
            'category' => Category::inRandomOrder()->first()?->id ?? Category::factory(), // Catégorie existante ou factory
            'document_path' => $this->faker->url, // URL fictive
            'recipient' => Recipient::inRandomOrder()->first()?->id ?? Recipient::factory(), // Destinataire existant ou factory
            'copy_to' => json_encode(User::inRandomOrder()->take(rand(1, 3))->pluck('id')->toArray()), // Liste JSON d'utilisateurs
            'year' => $this->faker->numberBetween(2020, 2024), // Année aléatoire
        ];
    }
}
