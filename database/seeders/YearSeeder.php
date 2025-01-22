<?php

namespace Database\Seeders;

use App\Models\Year;
use Illuminate\Database\Seeder;

class YearSeeder extends Seeder
{
    public function run()
    {
        $years = [2024,2025,2026,2027,2028];

        foreach ($years as $year) {
            Year::create(['year' => $year]);
        }
    }
}
