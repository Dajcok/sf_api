<?php

namespace tests\Feature\Models;

use App\Models\Item;
use tests\Feature\Models\Abstract\BaseModelFeatureTestContract;
use Tests\TestCase;

class ItemModelFeatureTest extends TestCase implements BaseModelFeatureTestContract
{

    public function testCreateAndFind(): void
    {
        $item = Item::factory([
            'name' => 'Big Mac',
            'price' => 5.99,
            'ingredients' => 'Bun, beef patty, lettuce, cheese, pickles, onions, special sauce',
        ])->create();

        $retrievedItem = Item::findOrFail($item->id);

        $this->assertEquals($item->id, $retrievedItem->id);
        $this->assertEquals('Big Mac', $retrievedItem->name);
        $this->assertEquals(5.99, $retrievedItem->price);
        $this->assertEquals('Bun, beef patty, lettuce, cheese, pickles, onions, special sauce', $retrievedItem->ingredients);
    }

    public function testUpdate(): void
    {
        $item = Item::factory([
            'name' => 'Big Mac',
            'price' => 5.99,
            'ingredients' => 'Bun, beef patty, lettuce, cheese, pickles, onions, special sauce',
        ])->create();

        $item->update([
            'name' => 'Quarter Pounder',
            'price' => 6.99,
            'ingredients' => 'Bun, beef patty, lettuce, cheese, pickles, onions, ketchup, mustard',
        ]);

        $retrievedItem = Item::findOrFail($item->id);

        $this->assertEquals($item->id, $retrievedItem->id);
        $this->assertEquals('Quarter Pounder', $retrievedItem->name);
        $this->assertEquals(6.99, $retrievedItem->price);
        $this->assertEquals('Bun, beef patty, lettuce, cheese, pickles, onions, ketchup, mustard', $retrievedItem->ingredients);
    }

    public function testDelete(): void
    {
        $item = Item::factory([
            'name' => 'Big Mac',
            'price' => 5.99,
            'ingredients' => 'Bun, beef patty, lettuce, cheese, pickles, onions, special sauce',
        ])->create();

        $item->delete();

        $this->assertNull(Item::find($item->id));
    }

    public function testFindAll(): void
    {
        Item::factory(10)->create();

        $items = Item::all();

        $this->assertCount(10, $items);
    }

    public function testFindAllWhere(): void
    {
        Item::factory(10)->create();

        Item::factory()->create([
            'name' => 'Fries',
            'price' => 2.99,
            'ingredients' => 'Potatoes, salt',
        ]);

        $items = Item::where('name', 'Fries')->get();

        $this->assertCount(1, $items);
    }
}
