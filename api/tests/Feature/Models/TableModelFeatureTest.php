<?php

namespace tests\Feature\Models;

use App\Models\Table;
use tests\Feature\Models\Abstract\BaseModelFeatureTestContract;
use Tests\TestCase;

class TableModelFeatureTest extends TestCase implements BaseModelFeatureTestContract
{

    public function testCreateAndFind(): void
    {
        $table = Table::factory([
            'number' => 7,
        ])->create();

        $retrievedTable = Table::findOrFail($table->id);

        $this->assertEquals($table->id, $retrievedTable->id);
        $this->assertEquals($table->number, $retrievedTable->number);
        $this->assertEquals($table->restaurant_id, $retrievedTable->restaurant_id);
    }

    public function testUpdate(): void
    {
        $table = Table::factory([
            'number' => 7,
        ])->create();

        $table->update([
            'number' => 8,
        ]);

        $retrievedTable = Table::findOrFail($table->id);

        $this->assertEquals($table->id, $retrievedTable->id);
        $this->assertEquals(8, $retrievedTable->number);
        $this->assertEquals($table->restaurant_id, $retrievedTable->restaurant_id);
    }

    public function testDelete(): void
    {
        $table = Table::factory([
            'number' => 7,
        ])->create();

        $table->delete();

        $this->assertNull(Table::find($table->id));
    }

    public function testFindAll(): void
    {
        Table::factory(10)->create();

        $tables = Table::all();

        $this->assertCount(10, $tables);
    }

    public function testFindAllWhere(): void
    {
        Table::factory([
            'number' => 7,
        ])->create();

        Table::factory([
            'number' => 8,
        ])->create();

        $tables = Table::where('number', 7)->get();

        $this->assertCount(1, $tables);
    }
}
