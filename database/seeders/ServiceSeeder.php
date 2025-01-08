<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            ['name' => 'IT', 'description' => 'Service informatique'],
            ['name' => 'HR', 'description' => 'Ressources humaines'],
            ['name' => 'Finance', 'description' => 'Service financier'],
            ['name' => 'Marketing', 'description' => 'Service marketing'],
            ['name' => 'Sales', 'description' => 'Service commercial'],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
