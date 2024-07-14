<?php

namespace tests\Feature\E2E;

use App\Models\Table;
use App\Models\User;
use PDOException;
use Symfony\Component\HttpFoundation\Response;
use tests\Feature\E2E\Abstract\BaseE2ETest;

class TableE2ETest extends BaseE2ETest
{
    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function testUnauthorized(): void
    {
        $response = $this->withRequiredHeaders()->get(route('api.table.index'));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testIndexTablesEmpty(): void
    {
        $response = $this->asUser()->get(route('api.table.index'));

        $this->assertSuccessfullApiJsonStructureOnIndex($response);
        $this->assertEmpty($response->json('data.items'));
    }

    public function testIndexTables(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();
        $response = $this->asUser($user)->get(route('api.table.index'));

        $this->assertSuccessfullApiJsonStructureOnIndex($response);
        $this->assertNotEmpty($response->json('data.items'));
        $this->assertEquals(2, count($response->json('data.items')));
    }

    public function testIndexAllTables(): void
    {
        $admin = User::whereEmail('admin@developer.sk')->first();
        $response = $this->asUser($admin)->get(route('api.table.index'));

        $this->assertSuccessfullApiJsonStructureOnIndex($response);
        $this->assertNotEmpty($response->json('data.items'));
        $this->assertEquals(2, count($response->json('data.items')));
    }

    public function testShowTableForbidden(): void
    {
        $response = $this->asUser()->get(route('api.table.show', ['id' => app('TestTable1Id')]));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testShowTable(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();
        $response = $this->asUser($user)->get(route('api.table.show', ['id' => app('TestTable1Id')]));

        $response->assertStatus(Response::HTTP_OK);
        $this->assertSuccessfullApiJsonStructure($response, [
            'id',
            'number',
            'restaurant_id',
            'x',
            'y',
        ]);

        $this->assertEquals(app('TestTable1Id'), $response->json('data.id'));
        $this->assertEquals('Table 1', $response->json('data.number'));
        $this->assertEquals(app('TestRestaurant1Id'), $response->json('data.restaurant_id'));
    }

    public function testUpdateTableForbidden(): void
    {
        $response = $this->asUser()->put(route('api.table.update', ['id' => app('TestTable1Id')]), [
            'number' => 'Table 1 Updated',
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testUpdateTable(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();
        $response = $this->asUser($user)->put(route('api.table.update', ['id' => app('TestTable1Id')]), [
            'number' => 'Table 1 Updated',
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertSuccessfullApiJsonStructure($response, [
            'id',
            'number',
            'restaurant_id',
            'x',
            'y',
        ]);

        $this->assertEquals(app('TestTable1Id'), $response->json('data.id'));
        $this->assertEquals('Table 1 Updated', $response->json('data.number'));
        $this->assertEquals(app('TestRestaurant1Id'), $response->json('data.restaurant_id'));
    }

    public function testUpdateTableValidationError(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();
        $response = $this->asUser($user)->put(route('api.table.update', ['id' => app('TestTable1Id')]), [
            'number' => 'Table 1 Updated',
            'restaurant_id' => 999,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['restaurant_id', 'number']);
    }

    public function testUpdateTableNotFound(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();
        $response = $this->asUser($user)->put(route('api.table.update', ['id' => 999]), [
            'number' => 4,
        ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testStoreTableForbidden(): void
    {
        $response = $this->asUser()->post(route('api.table.store'), [
            'number' => 3,
            'restaurant_id' => app('TestRestaurant1Id'),
            'x' => 1,
            'y' => 1,
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testStoreTable(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();
        $response = $this->asUser($user)->post(route('api.table.store'), [
            'number' => 3,
            'restaurant_id' => app('TestRestaurant1Id'),
            'x' => 1,
            'y' => 1,
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertSuccessfullApiJsonStructure($response, [
            'id',
            'number',
            'restaurant_id',
            'x',
            'y',
        ]);
    }

    public function testStoreTableValidationError(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();
        $response = $this->asUser($user)->post(route('api.table.store'), [
            'number' => 3,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['restaurant_id', 'x', 'y']);

        $response = $this->asUser($user)->post(route('api.table.store'), [
            'restaurant_id' => app('TestRestaurant1Id'),
            'x' => 1,
            'y' => 1,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['number']);

        $response = $this->asUser($user)->post(route('api.table.store'), [
            'number' => 3,
            'restaurant_id' => 999,
            'x' => 1,
            'y' => 1,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['restaurant_id']);
    }

    public function testDeleteTableForbidden(): void
    {
        $response = $this->asUser()->delete(route('api.table.destroy', ['id' => app('TestTable1Id')]));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
        $table = Table::get(app('TestTable1Id'));
        $this->assertNotNull($table);
    }

    public function testDeleteTable(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();
        $response = $this->asUser($user)->delete(route('api.table.destroy', ['id' => app('TestTable1Id')]));

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->expectException(PDOException::class);
        Table::get(app('TestTable1Id'));
    }

    public function testDeleteTableNotFound(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();
        $response = $this->asUser($user)->delete(route('api.table.destroy', ['id' => 999]));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
