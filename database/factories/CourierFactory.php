<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Courier>
 */
class CourierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'object' => $this->faker->text(25),
            'annual_id' => $this->faker->unique()->randomNumber(8),
            'nature'  => Category::all()->random()->name,
            'id_handling_user' => 1,
        ];
    }
}
