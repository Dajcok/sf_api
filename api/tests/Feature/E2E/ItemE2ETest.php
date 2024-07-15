<?php

namespace tests\Feature\E2E;

use App\Models\Item;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use tests\Feature\E2E\Abstract\BaseE2ETest;

class ItemE2ETest extends BaseE2ETest
{
    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function testUnauthorized(): void
    {
        $response = $this->withRequiredHeaders()->get(route('api.item.index'));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testIndexAllItems(): void
    {
        $response = $this->asUser()->get(route('api.item.index'));

        $this->assertSuccessfullApiJsonStructureOnIndex($response);
        $this->assertNotEmpty($response->json('data.items'));
        $this->assertEquals(4, count($response->json('data.items')));
    }

    public function testShowItem(): void
    {
        $response = $this->asUser()->get(route('api.item.show', ['id' => app('TestItem1Id')]));

        $response->assertStatus(Response::HTTP_OK);
        $this->assertSuccessfullApiJsonStructure($response, [
            'id',
            'restaurant_id',
            'ingredients',
            'name',
            'price',
        ]);

        $this->assertEquals(app('TestItem1Id'), $response->json('data.id'));
        $this->assertEquals(app('TestRestaurant1Id'), $response->json('data.restaurant_id'));
    }

    public function testUpdateItemForbidden(): void
    {
        $user = User::whereEmail('restaurant@owner2.sk')->first();
        $response = $this->asUser($user)->json('PUT', route('api.item.update', ['id' => app('TestItem1Id')]), [
            'price' => 81,
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testUpdateItem(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();
        $response = $this->asUser($user)->json('PUT', route('api.item.update', ['id' => app('TestItem1Id')]), [
            'price' => 81,
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertSuccessfullApiJsonStructure($response, [
            'id',
            'restaurant_id',
            'ingredients',
            'name',
            'price',
        ]);

        $this->assertEquals(app('TestItem1Id'), $response->json('data.id'));
        $this->assertEquals(81, $response->json('data.price'));
        $this->assertEquals(app('TestRestaurant1Id'), $response->json('data.restaurant_id'));
    }

    public function testUpdateItemValidationError(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();
        $response = $this->asUser($user)->json('PUT', route('api.item.update', ['id' => app('TestItem1Id')]), [
            'price' => 'Item 1 Updated',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['price']);
    }

    public function testUpdateItemNotFound(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();
        $response = $this->asUser($user)->json('PUT', route('api.item.update', ['id' => 999]), [
            'price' => 4,
        ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testStoreItemForbidden(): void
    {
        $user = User::whereEmail('restaurant@owner2.sk')->first();
        $response = $this->asUser($user)->postJson(route('api.item.store'), [
            'price' => 3,
            'restaurant_id' => app('TestRestaurant1Id'),
            'ingredients' => 'Test ingredients',
            'name' => 'Test name',
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testStoreItem(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();
        $response = $this->asUser($user)->postJson(route('api.item.store'), [
            'price' => 3,
            'restaurant_id' => app('TestRestaurant1Id'),
            'ingredients' => 'Test ingredients',
            'name' => 'Test name',
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertSuccessfullApiJsonStructure($response, [
            'id',
            'restaurant_id',
            'ingredients',
            'name',
            'price',
        ], Response::HTTP_CREATED);
    }

    public function testStoreItemValidationError(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();
        $response = $this->asUser($user)->postJson(route('api.item.store'), [
            'price' => 3,
            'restaurant_id' => app('TestRestaurant1Id'),
            'ingredients' => 'Test ingredients',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['name']);

        $response = $this->asUser($user)->postJson(route('api.item.store'), [
            'price' => 3,
            'restaurant_id' => app('TestRestaurant1Id'),
            'name' => 'Test name',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['ingredients']);

        $response = $this->asUser($user)->postJson(route('api.item.store'), [
            'restaurant_id' => app('TestRestaurant1Id'),
            'ingredients' => 'Test ingredients',
            'name' => 'Test name',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['price']);

        $response = $this->asUser($user)->postJson(route('api.item.store'), [
            'price' => 3,
            'ingredients' => 'Test ingredients',
            'name' => 'Test name',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['restaurant_id']);
    }

    public function testDeleteItemForbidden(): void
    {
        $response = $this->asUser()->delete(route('api.item.destroy', ['id' => app('TestItem2Id')]));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
        $table = Item::find(app('TestItem2Id'));
        $this->assertNotNull($table);
    }

    public function testDeleteItem(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();
        $response = $this->asUser($user)->delete(route('api.item.destroy', ['id' => app('TestItem1Id')]));

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertNull(Item::find(app('TestItem1Id')));
    }

    public function testDeleteItemNotFound(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();
        $response = $this->asUser($user)->delete(route('api.item.destroy', ['id' => 999]));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
