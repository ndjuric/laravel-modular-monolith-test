<?php

namespace Database\Seeders;

use App\Models\Venue;
use Illuminate\Database\Seeder;

class VenueSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Venue::create([
            'name' => 'Main Venue',
            'capacity' => 150
        ]);

        Venue::create([
            'name' => 'Small Venue',
            'capacity' => 50
        ]);
    }
}
