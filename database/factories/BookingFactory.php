<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->numberBetween(6, 15),
            'ticket_id' => fake()->numberBetween(1, 15),
            'quantity' => fake()->numberBetween(1, 10),
            'status' => 'pending'
        ];
    }

    public function confirmed(){
        return $this->state(fn(array $attributes) => ['status' => 'confirmed']);
    }

    public function cancelled(){
        return $this->state(fn(array $attributes) => ['status' => 'cancelled']);
    }
}
