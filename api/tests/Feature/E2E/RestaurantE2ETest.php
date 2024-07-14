<?php

namespace tests\Feature\E2E;

use App\Models\User;
use Database\Seeders\RestaurantSeeder;
use Symfony\Component\HttpFoundation\Response;
use tests\Feature\E2E\Abstract\BaseE2ETest;

class RestaurantE2ETest extends BaseE2ETest
{
    protected array $authorizedRoutes = [
        'api.restaurant.index',
        'api.restaurant.show',
        'api.restaurant.update',
        'api.restaurant.destroy',
    ];

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(RestaurantSeeder::class);
    }

    public function testIndexRestaurantsEmpty(): void
    {
        $response = $this->asUser()->get(route('api.restaurant.index'));

        $this->assertSuccessfullApiJsonStructureOnIndex($response);
        $this->assertEmpty($response->json('data.items'));
    }

    public function testIndexRestaurants(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();

        $response = $this->asUser($user)->get(route('api.restaurant.index'));

        $this->assertSuccessfullApiJsonStructureOnIndex($response);
        $this->assertNotEmpty($response->json('data.items'));
        $this->assertEquals(1, count($response->json('data.items')));
    }

    public function testIndexAllRestaurants(): void
    {
        $admin = User::whereEmail('admin@developer.sk')->first();

        $response = $this->asUser($admin)->get(route('api.restaurant.index.all'));

        $this->assertSuccessfullApiJsonStructureOnIndex($response);
        $this->assertNotEmpty($response->json('data.items'));
        $this->assertEquals(2, count($response->json('data.items')));
    }

    public function testRetrieveRestaurantForbidden(): void
    {
        $response = $this->asUser()->get(route('api.restaurant.show', ['restaurant' => 1]));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testRetrieveRestaurant(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();

        $response = $this->asUser($user)->get(route('api.restaurant.show', ['restaurant' => 1]));

        $this->assertSuccessfullApiJsonStructure($response, [
            'id',
            'name',
            'formatted_address',
        ]);
    }

    public function testUpdateRestaurantForbidden(): void
    {
        $response = $this->asUser()->put(route('api.restaurant.update', ['restaurant' => 1]), [
            'name' => 'Test Restaurant Updated',
            'formatted_address' => '123 Main St, City, State, Zip',
        ]);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testUpdateRestaurant(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();

        $response = $this->asUser($user)->put(route('api.restaurant.update', ['restaurant' => 1]), [
            'name' => 'Test Restaurant Updated',
            'formatted_address' => '123 Main St, City, State, Zip',
        ]);

        $this->assertSuccessfullApiJsonStructure($response, [
            'id',
            'name',
            'formatted_address',
        ]);

        $this->assertEquals('Test Restaurant Updated', $response->json('data.name'));
    }

    public function testDeleteRestaurantForbidden(): void
    {
        $response = $this->asUser()->delete(route('api.restaurant.destroy', ['restaurant' => 1]));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testDeleteRestaurant(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();

        $response = $this->asUser($user)->delete(route('api.restaurant.destroy', ['restaurant' => 1]));

        $response->assertStatus(Response::HTTP_NO_CONTENT);
    }

    public function testDeleteRestaurantNotFound(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();

        $response = $this->asUser($user)->delete(route('api.restaurant.destroy', ['restaurant' => 999]));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
