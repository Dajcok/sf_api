<?php

namespace tests\Feature\Models;

use App\Models\Restaurant;
use tests\Feature\Models\Abstract\BaseModelFeatureTestContract;
use Tests\TestCase;

class RestaurantModelFeatureTest extends TestCase implements BaseModelFeatureTestContract
{
    public function testCreateAndFind(): void
    {
        $restaurant = Restaurant::factory([
            'name' => 'McDonalds',
            'formatted_address' => '1234 Main St, Springfield, IL 62701',
        ])->create();

        $retrievedRestaurant = Restaurant::findOrFail($restaurant->id);

        $this->assertEquals($restaurant->id, $retrievedRestaurant->id);
        $this->assertEquals('McDonalds', $retrievedRestaurant->name);
        $this->assertEquals('1234 Main St, Springfield, IL 62701', $retrievedRestaurant->formatted_address);

    }

    public function testUpdate(): void
    {
        $restaurant = Restaurant::factory([
            'name' => 'McDonalds',
            'formatted_address' => '1234 Main St, Springfield, IL 62701',
        ])->create();

        $restaurant->update([
            'name' => 'Burger King',
            'formatted_address' => '5678 Elm St, Springfield, IL 62702',
        ]);

        $retrievedRestaurant = Restaurant::findOrFail($restaurant->id);

        $this->assertEquals($restaurant->id, $retrievedRestaurant->id);
        $this->assertEquals('Burger King', $retrievedRestaurant->name);
        $this->assertEquals('5678 Elm St, Springfield, IL 62702', $retrievedRestaurant->formatted_address);
    }

    public function testDelete(): void
    {
        $restaurant = Restaurant::factory([
            'name' => 'McDonalds',
            'formatted_address' => '1234 Main St, Springfield, IL 62701',
        ])->create();

        $restaurant->delete();

        $this->assertNull(Restaurant::find($restaurant->id));
    }

    public function testFindAll(): void
    {
        Restaurant::factory(10)->create();

        $restaurants = Restaurant::all();

        $this->assertCount(10, $restaurants);
    }

    public function testFindAllWhere(): void
    {
        Restaurant::factory(10)->create([
            'name' => 'McDonalds',
        ]);

        $restaurants = Restaurant::where('name', 'McDonalds')->get();

        $this->assertCount(10, $restaurants);
    }
}
