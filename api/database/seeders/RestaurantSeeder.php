<?php

namespace Database\Seeders;

use App;
use App\Enums\UserRoleEnum;
use App\Models\Item;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\Table;
use App\Models\User;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This creates several test restaurants, tables and its owners.
     */
    public function run(): void
    {
        $restaurant1 = Restaurant::factory()->create([
            'name' => 'Test Restaurant',
            'formatted_address' => '123 Main St, City, State, Zip',
        ]);

        $table1 = Table::factory()->create([
            'restaurant_id' => $restaurant1->id,
            'number' => 1,
        ]);

        $table2 = Table::factory()->create([
            'restaurant_id' => $restaurant1->id,
            'number' => 2,
        ]);

        $item1 = Item::factory()->create([
            'restaurant_id' => $restaurant1->id,
        ]);

        $item2 = Item::factory()->create([
            'restaurant_id' => $restaurant1->id,
        ]);

        $customer1 = User::factory()->create([
            'role' => UserRoleEnum::CUSTOMER->value,
        ]);

        $order1 = Order::factory()->create([
            'restaurant_id' => $restaurant1->id,
            'created_by' => $customer1->id,
        ]);

        $customer2 = User::factory()->create([
            'role' => UserRoleEnum::CUSTOMER->value,
        ]);

        $order2 = Order::factory()->create([
            'created_by' => $customer2->id,
            'restaurant_id' => $restaurant1->id,
        ]);

        $owner1 = User::factory()->create([
            'name' => 'Test User',
            'email' => 'restaurant@owner.sk',
            'restaurant_id' => $restaurant1->id,
            'role' => UserRoleEnum::RESTAURANT_STAFF->value,
        ]);

        $restaurant2 = Restaurant::factory()->create([
            'name' => 'Test Restaurant 2',
            'formatted_address' => '456 Main St, City, State, Zip',
        ]);

        $table3 = Table::factory()->create([
            'restaurant_id' => $restaurant2->id,
            'number' => 3,
        ]);

        $table4 = Table::factory()->create([
            'restaurant_id' => $restaurant2->id,
            'number' => 4,
        ]);

        $item3 = Item::factory()->create([
            'restaurant_id' => $restaurant2->id,
        ]);

        $item4 = Item::factory()->create([
            'restaurant_id' => $restaurant2->id,
        ]);

        $order3 = Order::factory()->create([
            'restaurant_id' => $restaurant2->id,
        ]);

        $order4 = Order::factory()->create([
            'restaurant_id' => $restaurant2->id,
        ]);

        $owner2 = User::factory()->create([
            'name' => 'Test User',
            'email' => 'restaurant@owner2.sk',
            'restaurant_id' => $restaurant2->id,
            'role' => UserRoleEnum::RESTAURANT_STAFF->value,
        ]);

        App::instance('TestRestaurant1Id', $restaurant1->id);
        App::instance('TestRestaurant2Id', $restaurant2->id);
        App::instance('TestRestaurantOwner1Id', $owner1->id);
        App::instance('TestRestaurantOwner2Id', $owner2->id);
        App::instance('TestTable1Id', $table1->id);
        App::instance('TestTable2Id', $table2->id);
        App::instance('TestTable3Id', $table3->id);
        App::instance('TestTable4Id', $table4->id);
        App::instance('TestItem1Id', $item1->id);
        App::instance('TestItem2Id', $item2->id);
        App::instance('TestItem3Id', $item3->id);
        App::instance('TestItem4Id', $item4->id);
        App::instance('TestOrder1Id', $order1->id);
        App::instance('TestOrder2Id', $order2->id);
        App::instance('TestOrder3Id', $order3->id);
        App::instance('TestOrder4Id', $order4->id);
        App::instance('TestCustomer1Id', $customer1->id);
        App::instance('TestCustomer2Id', $customer2->id);
    }
}
