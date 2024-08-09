<?php

namespace Tests\Feature\E2E;

use App\Models\Category;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\E2E\Abstract\BaseE2ETest;

class CategoryE2ETest extends BaseE2ETest
{
    public function setUp(): void
    {
        parent::setUp();

        $this->seed();
    }

    public function testUnauthorized(): void
    {
        $response = $this->withRequiredHeaders()->get(route('api.category.index'));

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
    }

    public function testIndexAllCategories(): void
    {
        $response = $this->asUser()->get(route('api.category.index'));

        $this->assertSuccessfullApiJsonStructureOnIndex($response);
        $this->assertNotEmpty($response->json('data.categories'));
        $this->assertEquals(4, count($response->json('data.categories')));
    }

    public function testShowCategory(): void
    {
        $response = $this->asUser()->get(route('api.category.show', ['id' => app('TestCategory1Id')]));

        $response->assertStatus(Response::HTTP_OK);
        $this->assertSuccessfullApiJsonStructure($response, [
            'id',
            'code_name',
            'label',
            'restaurant_id',
        ]);

        $this->assertEquals(app('TestCategory1Id'), $response->json('data.id'));
        $this->assertEquals(app('TestRestaurant1Id'), $response->json('data.restaurant_id'));
    }

    public function testUpdateCategoryForbidden(): void
    {
        $user = User::whereEmail('restaurant@owner2.sk')->first();
        $response = $this->asUser($user)->json('PUT', route('api.category.update', ['id' => app('TestCategory1Id')]), [
            'label' => 'Updated Label',
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testUpdateCategory(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();
        $response = $this->asUser($user)->json('PUT', route('api.category.update', ['id' => app('TestCategory1Id')]), [
            'label' => 'Updated Label',
        ]);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertSuccessfullApiJsonStructure($response, [
            'id',
            'code_name',
            'label',
            'restaurant_id',
        ]);

        $this->assertEquals(app('TestCategory1Id'), $response->json('data.id'));
        $this->assertEquals('Updated Label', $response->json('data.label'));
        $this->assertEquals(app('TestRestaurant1Id'), $response->json('data.restaurant_id'));
    }

    public function testUpdateCategoryValidationError(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();
        $response = $this->asUser($user)->json('PUT', route('api.category.update', ['id' => app('TestCategory1Id')]), [
            'label' => null,
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['label']);
    }

    public function testUpdateCategoryNotFound(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();
        $response = $this->asUser($user)->json('PUT', route('api.category.update', ['id' => 999]), [
            'label' => 'Updated Label',
        ]);

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public function testStoreCategoryForbidden(): void
    {
        $user = User::whereEmail('restaurant@owner2.sk')->first();
        $response = $this->asUser($user)->postJson(route('api.category.store'), [
            'code_name' => 'new_category',
            'label' => 'New Category',
            'restaurant_id' => app('TestRestaurant1Id'),
        ]);

        $response->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function testStoreCategory(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();
        $response = $this->asUser($user)->postJson(route('api.category.store'), [
            'code_name' => 'new_category',
            'label' => 'New Category',
            'restaurant_id' => app('TestRestaurant1Id'),
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
        $this->assertSuccessfullApiJsonStructure($response, [
            'id',
            'code_name',
            'label',
            'restaurant_id',
        ], Response::HTTP_CREATED);
    }

    public function testStoreCategoryValidationError(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();
        $response = $this->asUser($user)->postJson(route('api.category.store'), [
            'label' => 'New Category',
            'restaurant_id' => app('TestRestaurant1Id'),
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['code_name']);

        $response = $this->asUser($user)->postJson(route('api.category.store'), [
            'code_name' => 'new_category',
            'restaurant_id' => app('TestRestaurant1Id'),
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['label']);

        $response = $this->asUser($user)->postJson(route('api.category.store'), [
            'code_name' => 'new_category',
            'label' => 'New Category',
        ]);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors(['restaurant_id']);
    }

    public function testDeleteCategoryForbidden(): void
    {
        $response = $this->asUser()->delete(route('api.category.destroy', ['id' => app('TestCategory2Id')]));

        $response->assertStatus(Response::HTTP_FORBIDDEN);
        $category = Category::find(app('TestCategory2Id'));
        $this->assertNotNull($category);
    }

    public function testDeleteCategory(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();
        $response = $this->asUser($user)->delete(route('api.category.destroy', ['id' => app('TestCategory1Id')]));

        $response->assertStatus(Response::HTTP_NO_CONTENT);
        $this->assertNull(Category::find(app('TestCategory1Id')));
    }

    public function testDeleteCategoryNotFound(): void
    {
        $user = User::whereEmail('restaurant@owner.sk')->first();
        $response = $this->asUser($user)->delete(route('api.category.destroy', ['id' => 999]));

        $response->assertStatus(Response::HTTP_NOT_FOUND);
    }
}
