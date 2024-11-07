<?php

namespace Modules\Payment\Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Event\Entities\Event;
use Modules\Payment\Entities\Purchase;
use Modules\Venue\Entities\Venue;
use Carbon\Carbon;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_ticket_purchase()
    {
        $venue = Venue::factory()->create(['capacity' => 100]);
        $event = Event::factory()->create([
            'venue_id' => $venue->id,
            'ticket_sales_end_date' => now()->addDay(),
        ]);
        $response = $this->postJson("/api/events/{$event->id}/purchase", [
            'email' => 'user@example.com',
        ]);
        $response->assertStatus(200)->assertJsonStructure(['transaction_id']);
    }
    
    public function test_duplicate_email_error()
    {
        $venue = Venue::factory()->create(['capacity' => 100]);
        $event = Event::factory()->create([
            'venue_id' => $venue->id,
            'ticket_sales_end_date' => now()->addDay(),
        ]);
        Purchase::factory()->create([
            'event_id' => $event->id,
            'email' => 'user@example.com',
        ]);
        $response = $this->postJson("/api/events/{$event->id}/purchase", [
            'email' => 'user@example.com',
        ]);
        $response->assertStatus(400)->assertExactJson(['error' => 'Email already used for this event.']);
    }
    
    public function test_no_available_seats_error()
    {
        $venue = Venue::factory()->create(['capacity' => 1]);
        $event = Event::factory()->create([
            'venue_id' => $venue->id,
            'ticket_sales_end_date' => now()->addDay(),
        ]);
        Purchase::factory()->create([
            'event_id' => $event->id,
        ]);
        $response = $this->postJson("/api/events/{$event->id}/purchase", [
            'email' => 'newuser@example.com',
        ]);
        $response->assertStatus(400)->assertExactJson(['error' => 'No available seats for this event.']);
    }
    
    public function test_event_is_closed_error()
    {
        $venue = Venue::factory()->create(['capacity' => 100]);
        $event = Event::factory()->create([
            'venue_id' => $venue->id,
            'ticket_sales_end_date' => now()->subDay(),
        ]);
        $response = $this->postJson("/api/events/{$event->id}/purchase", [
            'email' => 'user@example.com',
        ]);
        $response->assertStatus(400)->assertExactJson(['error' => 'The event is closed.']);
    }
}