<?php

namespace tests\Feature\E2E;

use App\Models\Order;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use tests\Feature\E2E\Abstract\BaseE2ETest;

class OrderE2ETest extends BaseE2ETest
{
//    public function setUp(): void
//    {
//        parent::setUp();
//
//        $this->seed();
//    }
//
//    public function testUnauthorized(): void
//    {
//        $response = $this->withRequiredHeaders()->get(route('api.order.index'));
//
//        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
//    }
//
//    public function testIndexOrdersEmpty(): void
//    {
//        $response = $this->asUser()->get(route('api.order.index'));
//
//        $this->assertSuccessfullApiJsonStructureOnIndex($response);
//        $this->assertEmpty($response->json('data.items'));
//    }
//
//    public function testIndexOrdersAsRestaurantOwner(): void
//    {
//        $user = User::whereEmail('restaurant@owner.sk')->first();
//        $response = $this->asUser($user)->get(route('api.order.index'));
//
//        $this->assertSuccessfullApiJsonStructureOnIndex($response);
//        $this->assertNotEmpty($response->json('data.items'));
//        $this->assertEquals(2, count($response->json('data.items')));
//    }
//
//    public function testIndexOrdersAsCustomer(): void
//    {
//        $user = User::find(app('TestCustomer1Id'));
//        $response = $this->asUser($user)->get(route('api.order.index'));
//
//        $this->assertSuccessfullApiJsonStructureOnIndex($response);
//        $this->assertNotEmpty($response->json('data.items'));
//        $this->assertEquals(1, count($response->json('data.items')));
//    }
//
//    public function testIndexAllOrders(): void
//    {
//        $admin = User::whereEmail('admin@developer.sk')->first();
//        $response = $this->asUser($admin)->get(route('api.order.index'));
//
//        $this->assertSuccessfullApiJsonStructureOnIndex($response);
//        $this->assertNotEmpty($response->json('data.items'));
//        $this->assertEquals(4, count($response->json('data.items')));
//    }
//
//    public function testShowOrderForbidden(): void
//    {
//        $response = $this->asUser()->get(route('api.order.show', ['id' => app('TestOrder1Id')]));
//
//        $response->assertStatus(Response::HTTP_FORBIDDEN);
//    }
//
//    public function testShowOrderAsRestaurantOwner(): void
//    {
//        $user = User::whereEmail('restaurant@owner.sk')->first();
//        $response = $this->asUser($user)->get(route('api.order.show', ['id' => app('TestOrder1Id')]));
//
//        $response->assertStatus(Response::HTTP_OK);
//        $this->assertSuccessfullApiJsonStructure($response, [
//            'restaurant_id',
//            'total',
//            'status',
//            'table_id',
//            'notes',
//            'items',
//            'created_by',
//        ]);
//
//        $this->assertEquals(app('TestOrder1Id'), $response->json('data.id'));
//        $this->assertEquals(app('TestRestaurant1Id'), $response->json('data.restaurant_id'));
//    }
//
//    public function testShowOrderAsCustomer(): void
//    {
//        $user = User::find(app('TestCustomer1Id'));
//        $response = $this->asUser($user)->get(route('api.order.show', ['id' => app('TestOrder1Id')]));
//
//        $response->assertStatus(Response::HTTP_OK);
//        $this->assertSuccessfullApiJsonStructure($response, [
//            'restaurant_id',
//            'total',
//            'status',
//            'table_id',
//            'notes',
//            'items',
//            'created_by',
//        ]);
//
//        $this->assertEquals(app('TestOrder1Id'), $response->json('data.id'));
//        $this->assertEquals(app('TestRestaurant1Id'), $response->json('data.restaurant_id'));
//    }
//
//    public function testUpdateOrderForbidden(): void
//    {
//        $response = $this->asUser()->json('PUT', route('api.order.update', ['id' => app('TestOrder1Id')]), [
//            'total' => 81,
//        ]);
//
//        $response->assertStatus(Response::HTTP_FORBIDDEN);
//    }
//
//    public function testUpdateOrderAsRestaurantOwner(): void
//    {
//        $user = User::whereEmail('restaurant@owner.sk')->first();
//        $response = $this->asUser($user)->json('PUT', route('api.order.update', ['id' => app('TestOrder1Id')]), [
//            'notes' => 'Random',
//        ]);
//
//        $response->assertStatus(Response::HTTP_OK);
//        $this->assertSuccessfullApiJsonStructure($response, [
//            'restaurant_id',
//            'total',
//            'status',
//            'table_id',
//            'notes',
//            'items',
//            'created_by',
//        ]);
//
//        $this->assertEquals(app('TestOrder1Id'), $response->json('data.id'));
//        $this->assertEquals(81, $response->json('data.total'));
//        $this->assertEquals(app('TestRestaurant1Id'), $response->json('data.restaurant_id'));
//    }
//
//    public function testUpdateOrderAsCustomer(): void
//    {
//        $user = User::find(app('TestCustomer1Id'));
//        $response = $this->asUser($user)->json('PUT', route('api.order.update', ['id' => app('TestOrder1Id')]), [
//            'total' => 85,
//        ]);
//
//        $response->assertStatus(Response::HTTP_OK);
//        $this->assertSuccessfullApiJsonStructure($response, [
//            'restaurant_id',
//            'total',
//            'status',
//            'table_id',
//            'notes',
//            'items',
//            'created_by',
//        ]);
//
//        $this->assertEquals(app('TestOrder1Id'), $response->json('data.id'));
//        $this->assertEquals(85, $response->json('data.total'));
//        $this->assertEquals(app('TestRestaurant1Id'), $response->json('data.restaurant_id'));
//    }

    //TODO: dokonči, pridaj unit testy na order service
}
