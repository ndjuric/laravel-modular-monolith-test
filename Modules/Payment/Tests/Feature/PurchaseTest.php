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

    public function test_can_purchase_ticket_successfully()
    {
        // Arrange
        $event = Event::factory()->create([
            'ticket_sales_end_date' => Carbon::now()->addDay(),
        ]);

        // Act
        $response = $this->postJson("/api/events/{$event->id}/purchase", [
            'email' => 'test@example.com',
        ]);

        // Assert
        $response->assertStatus(200)
                 ->assertJsonStructure(['transaction_id']);

        $this->assertDatabaseHas('purchases', [
            'event_id' => $event->id,
            'email'    => 'test@example.com',
        ]);
    }

    public function test_cannot_purchase_with_duplicate_email()
    {
        // Arrange
        $event = Event::factory()->create([
            'ticket_sales_end_date' => Carbon::now()->addDay(),
        ]);

        Purchase::factory()->create([
            'event_id' => $event->id,
            'email'    => 'test@example.com',
        ]);

        // Act
        $response = $this->postJson("/api/events/{$event->id}/purchase", [
            'email' => 'test@example.com',
        ]);

        // Assert
        $response->assertStatus(400)
                 ->assertJson([
                     'error' => 'Email already used for this event.',
                 ]);
    }

    public function test_cannot_purchase_when_event_is_sold_out()
    {
        // Arrange
        $venue = Venue::factory()->create(['capacity' => 1]);

        $event = Event::factory()->create([
            'venue_id'              => $venue->id,
            'ticket_sales_end_date' => Carbon::now()->addDay(),
        ]);

        Purchase::factory()->create([
            'event_id' => $event->id,
        ]);

        // Act
        $response = $this->postJson("/api/events/{$event->id}/purchase", [
            'email' => 'new@example.com',
        ]);

        // Assert
        $response->assertStatus(400)
                 ->assertJson([
                     'error' => 'No available seats for this event.',
                 ]);
    }

    public function test_cannot_purchase_when_event_is_closed()
    {
        // Arrange
        $event = Event::factory()->create([
            'ticket_sales_end_date' => Carbon::now()->subDay(),
        ]);

        // Act
        $response = $this->postJson("/api/events/{$event->id}/purchase", [
            'email' => 'test@example.com',
        ]);

        // Assert
        $response->assertStatus(400)
                 ->assertJson([
                     'error' => 'The event is closed.',
                 ]);
    }
}