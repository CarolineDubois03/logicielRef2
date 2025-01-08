<?php

namespace Database\Seeders;

use App\Models\Recipient;
use Illuminate\Database\Seeder;

class RecipientSeeder extends Seeder
{
    public function run()
    {
        $recipients = ['John Doe', 'Jane Smith', 'Alice Johnson', 'Bob Brown', 'Emily Davis'];

        foreach ($recipients as $label) {
            Recipient::create(['label' => $label]);
        }
    }
}
