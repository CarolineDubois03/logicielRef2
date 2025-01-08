<?php

namespace Database\Seeders;

use App\Models\Year;
use Illuminate\Database\Seeder;

class YearSeeder extends Seeder
{
    public function run()
    {
        $years = [2020, 2021, 2022, 2023, 2024];

        foreach ($years as $year) {
            Year::create(['year' => $year]);
        }
    }
}
