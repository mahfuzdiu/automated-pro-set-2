<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TicketBookingApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user, 'sanctum');
        $event = Event::factory()->create(['created_by' => $user->id]);
        Ticket::factory()->create(['event_id' => $event->id, 'created_by' => $user->id]);
        $response = $this->postJson('/api/tickets/1/bookings', [
            'quantity' => 2
        ]);
        $response->assertStatus(201);
    }
}
