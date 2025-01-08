<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = ['Note d\'exécution', "Délibation", "Lettre"];

        foreach ($categories as $category) {
            Category::create(['name' => $category, 'id_service' => rand(1, 5)]);
        }
    }
}
