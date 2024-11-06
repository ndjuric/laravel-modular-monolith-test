<?php

namespace Modules\Event\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Event\Entities\Event;
use Tests\TestCase;

class EventTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_list_events()
    {
        Event::factory()->count(2)->create();
        $response = $this->getJson('/api/events');
        $response->assertStatus(200)->assertJsonStructure(['*' => ['event_name', 'available_tickets', 'venue_name', 'ticket_sales_end_date']]);
    }
}