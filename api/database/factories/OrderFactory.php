<?php

namespace Database\Factories;

use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userId = User::factory()->create()->id;
        $restaurantId = Restaurant::factory()->create()->id;

        return [
            'status' => 'ACTIVE',
            'total' => 202.50,
            'table_number' => 7,
            'notes' => 'Extra ketchup',
            'restaurant_id' => $restaurantId,
            'created_by' => $userId,
        ];
    }
}
