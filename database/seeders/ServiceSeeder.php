<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run()
    {
        $services = [
            ['name' => 'SDN', 'description' => 'Service développement numérique'],
            ['name' => 'SG', 'description' => 'Service secrétariat général'],
            ['name' => 'Finance', 'description' => 'Service financier'],
            ['name' => 'Marketing', 'description' => 'Service marketing'],
            ['name' => 'Sales', 'description' => 'Service commercial'],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
