<?php

namespace Database\Seeders;

use App;
use App\Enums\UserRoleEnum;
use App\Models\Restaurant;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@developer.sk',
            'is_admin' => true,
        ]);

        App::instance('TestAdminId', $admin->id);

        $this->call([
            RestaurantSeeder::class,
        ]);
    }
}
