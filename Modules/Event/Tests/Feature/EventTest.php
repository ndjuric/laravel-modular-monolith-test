<?php

namespace Modules\Event\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Event\Entities\Event;
use Modules\Venue\Entities\Venue;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_events()
    {
        $venue = Venue::factory()->create(['capacity' => 100]);
        Event::factory()->create([
            'name' => 'Event 1',
            'venue_id' => $venue->id,
            'ticket_sales_end_date' => '2024-11-16 23:59:59',
        ]);
        $response = $this->getJson('/api/events');
        $response->assertStatus(200)
                 ->assertJsonFragment([
                     'event_name' => 'Event 1',
                     'available_tickets' => 100,
                     'venue_name' => $venue->name,
                     'ticket_sales_end_date' => '2024-11-16 23:59:59',
                 ]);
    }
}