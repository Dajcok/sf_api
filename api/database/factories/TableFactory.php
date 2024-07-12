<?php

namespace Database\Factories;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;


class TableFactory extends Factory
{

    /**
     * @inheritDoc
     */
    public function definition()
    {
        $restaurantId = Restaurant::factory()->create()->id;

        return [
            'restaurant_id' => $restaurantId,
            'number' => $this->faker->numberBetween(1, 100),
            'x' => $this->faker->numberBetween(1, 100),
            'y' => $this->faker->numberBetween(1, 100),
        ];
    }
}
