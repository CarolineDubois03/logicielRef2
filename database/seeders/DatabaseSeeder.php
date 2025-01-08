<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AdditionalColumn;
use App\Models\Category;
use App\Models\Courier;
use App\Models\Service;
use App\Models\User;
use Database\Factories\CourierFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $services = [
            'Service Développement Numérique',
            'Service Ressources Humaines',
            'Service Comptabilité',
            'Service Logistique',
            'Service Juridique',
            'Service Communication',
        ];

        // Boucle pour créer chaque service
        foreach ($services as $serviceName) {
            Service::create([
                'name' => $serviceName,
            ]);
        }


        User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'login' => 'admin', // Add this line
            'email' => 'admin@gmail.com',
            'password' => bcrypt('admin123'),
            'id_service' => 1,
        ]);

        User::create([
            'first_name' => 'Sébastien',
            'last_name' => 'Merveille',
            'login' => 'sebmer',
            'email' => 'sebastien.merveille@ac.andenne.be',
            'password' => bcrypt('sebmer123'),
            'id_service' => 1,
        ]);

        User::create([
            'first_name' => 'Caroline',
            'last_name' => 'Dubois',
            'login' => 'carodub',
            'email' => 'caroline.dubois@ac.andenne.be',
            'password' => bcrypt('caroline123'),
            'id_service' => 1,
        ]);

        User::create([
            'first_name' => 'Jean',
            'last_name' => 'Dupont',
            'login' => 'jeandup',
            'email' => 'jeandup@hotmail.com',
            'password' => bcrypt('jeandup123'),
            'id_service' => 2,
        ]);

        $categories = [
            [
                'name' => 'Note d\'exécution',
                'id_service' => 1,
            ],
            [
                'name' => 'Délibération',
                'id_service' => 1,
            ],
          
      
        ];
        
        foreach ($categories as $category) {
            Category::create($category);
        }

        Courier::factory(10)->create();


        $additionalColumns = [
            'Agent en copie',
            'Destinataire',
        ];
        
        AdditionalColumn::create([
            'name' => 'Agent en copie',
            'required' => false,
            'id_service' => 1,

        ]);
        AdditionalColumn::create([
            'name' => 'Destinataire',
            'required' => false,
            'id_service' => 1,

        ]);

       
    }
}
