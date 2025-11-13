<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => 'standard',
            'price' => fake()->randomFloat(2, 100, 500),
            'quantity' => fake()->numberBetween(50, 100),
            'event_id' => fake()->numberBetween(1, 5),
            'created_by' => fake()->numberBetween(1, 5)
        ];
    }

    public function vip(){
        return $this->state(fn(array $attributes) => ['type' => 'vip']);
    }
}
