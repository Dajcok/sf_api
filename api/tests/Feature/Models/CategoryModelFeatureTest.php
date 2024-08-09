<?php

namespace Tests\Feature\Models;

use App\Models\Category;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryModelFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateAndFind(): void
    {
        $category = Category::factory([
            'code_name' => 'electronics',
            'label' => 'Electronics',
        ])->create();

        $retrievedCategory = Category::findOrFail($category->id);

        $this->assertEquals($category->id, $retrievedCategory->id);
        $this->assertEquals('electronics', $retrievedCategory->code_name);
        $this->assertEquals('Electronics', $retrievedCategory->label);
    }

    public function testUpdate(): void
    {
        $category = Category::factory([
            'code_name' => 'electronics',
            'label' => 'Electronics',
        ])->create();

        $category->update([
            'code_name' => 'gadgets',
            'label' => 'Gadgets',
        ]);

        $retrievedCategory = Category::findOrFail($category->id);

        $this->assertEquals($category->id, $retrievedCategory->id);
        $this->assertEquals('gadgets', $retrievedCategory->code_name);
        $this->assertEquals('Gadgets', $retrievedCategory->label);
    }

    public function testDelete(): void
    {
        $category = Category::factory([
            'code_name' => 'electronics',
            'label' => 'Electronics',
        ])->create();

        $category->delete();

        $this->assertNull(Category::find($category->id));
    }

    public function testFindAll(): void
    {
        Category::factory(10)->create();

        $categories = Category::all();

        $this->assertCount(10, $categories);
    }

    public function testFindAllWhere(): void
    {
        Category::factory(10)->create();

        Category::factory()->create([
            'code_name' => 'books',
            'label' => 'Books',
        ]);

        $categories = Category::where('code_name', 'books')->get();

        $this->assertCount(1, $categories);
    }
}
