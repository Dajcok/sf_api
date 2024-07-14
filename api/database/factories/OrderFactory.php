<?php

namespace Database\Factories;

use App\Enums\OrderStatusEnum;
use App\Models\Restaurant;
use App\Models\Table;
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
        $tableId = Table::factory()->create()->id;

        return [
            'status' => OrderStatusEnum::ACTIVE->value,
            'total' => 202.50,
            'table_id' => $tableId,
            'notes' => 'Extra ketchup',
            'restaurant_id' => $restaurantId,
            'created_by' => $userId,
        ];
    }
}
