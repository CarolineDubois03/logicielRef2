<?php

namespace Database\Seeders;

use App\Models\Courier;
use App\Models\Recipient;
use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Seeder;

class CourierSeeder extends Seeder
{
    public function run()
    {
        // Générer 50 courriers avec des relations aléatoires
        Courier::factory(50)->create()->each(function ($courier) {
            // Associer des destinataires aléatoires
            $courier->recipient = Recipient::inRandomOrder()->first()->id;

            // Associer une catégorie et un agent traitant aléatoires
            $courier->category = Category::inRandomOrder()->first()->id;
            $courier->id_handling_user = User::inRandomOrder()->first()->id;
            $users = User::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $courier->copiedUsers()->attach($users);
            $courier->save();
        });


    }
}
