<?php

namespace tests\Feature\E2E;

use App\Models\Restaurant;
use App\Models\User;
use PDOException;
use Symfony\Component\HttpFoundation\Response;
use tests\Feature\E2E\Abstract\BaseE2ETest;

class RestaurantE2ETest extends BaseE2ETest
{

    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function testUnauthorized(): void
    {
        $response = $this->withRequiredHeaders()->get(route('api.restaurant.index'));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
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
        $response = $this->asUser($admin)->get(route('api.restaurant.index'));

        $this->assertSuccessfullApiJsonStructureOnIndex($response);
        $this->assertNotEmpty($response->json('data.items'));
        $this->assertEquals(6, count($response->json('data.items')));
    }

    public function testShowRestaurantForbidden(): void
    {
        $response = $this->asUser()->get(route('api.restaurant.show', ['id' => app('TestRestaurant1Id')]));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testShowRestaurant(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();
        $response = $this->asUser($user)->get(route('api.restaurant.show', ['id' => app('TestRestaurant1Id')]));

        $this->assertSuccessfullApiJsonStructure($response, [
            'id',
            'name',
            'formatted_address',
        ]);
    }

    public function testShowRestaurantNotFound(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();
        $response = $this->asUser($user)->get(route('api.restaurant.show', ['id' => 999]));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testUpdateRestaurantForbidden(): void
    {
        $response = $this->asUser()->put(route('api.restaurant.update', ['id' => app('TestRestaurant1Id')]), [
            'name' => 'Test Restaurant Updated',
            'formatted_address' => '123 Main St, City, State, Zip',
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testUpdateRestaurant(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();
        $response = $this->asUser($user)->json('PUT', route('api.restaurant.update', ['id' => app('TestRestaurant1Id')]), [
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
}
