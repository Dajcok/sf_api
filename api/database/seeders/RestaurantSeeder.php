<?php

namespace Database\Seeders;

use App\Enums\UserRoleEnum;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Database\Seeder;

class RestaurantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * This creates several test restaurants and its owners.
     */
    public function run(): void
    {
        $restaurant = Restaurant::create([
            'name' => 'Test Restaurant',
            'formatted_address' => '123 Main St, City, State, Zip',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'restaurant@owner.sk',
            'restaurant_id' => $restaurant->id,
            'role' => UserRoleEnum::RESTAURANT_STAFF->value,
        ]);

        $restaurant2 = Restaurant::create([
            'name' => 'Test Restaurant 2',
            'formatted_address' => '456 Main St, City, State, Zip',
        ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'restaurant@owner2.sk',
            'restaurant_id' => $restaurant2->id,
            'role' => UserRoleEnum::RESTAURANT_STAFF->value,
        ]);

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@developer.sk',
            'is_admin' => true,
        ]);
    }
}
