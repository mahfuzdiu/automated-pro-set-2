<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class EventApiTest extends TestCase
{
    use RefreshDatabase;
    /**
     * data retrieve test
     */
    public function test_index(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        Event::factory()->create(['created_by' => $user->id]);
        $this->actingAs($user, 'sanctum');
        $response = $this->getJson('/api/events');
        $response->assertStatus(200);
    }

    /**
     *
     */
    public function test_store(): void
    {
        $user = User::factory()->create(['role' => 'admin']);
        $this->actingAs($user, 'sanctum');
        $response = $this->postJson('/api/events', [
            'title' => 'event title',
            'description' => 'event description',
            'date' => '2025-10-10',
            'location' => 'Dhaka',
            'created_by' => $user->id
        ]);

        $response->assertStatus(200);
    }
}
