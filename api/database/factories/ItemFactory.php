<?php
namespace Database\Factories;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{

    /**
     * @inheritDoc
     */
    public function definition(): array
    {
        $restaurantId = Restaurant::factory()->create()->id;

        return [
            'name' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 0, 100),
            'ingredients' => $this->faker->text,
            'restaurant_id' => $restaurantId,
        ];
    }
}
