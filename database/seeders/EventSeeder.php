<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Venue;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mainVenue = Venue::where('name', 'Main Venue')->first();
        $smallVenue = Venue::where('name', 'Small Venue')->first();

        Event::create([
            'venue_id' => $mainVenue->id,
            'name' => 'Concert',
            'available_tickets' => 150,
            'ticket_sales_end_date' => '2024-09-15 18:00:00'
        ]);

        Event::create([
            'venue_id' => $smallVenue->id,
            'name' => 'Lecture',
            'available_tickets' => 50,
            'ticket_sales_end_date' => '2024-10-01 12:00:00'
        ]);
    }
}
