<?php

namespace tests\Feature\Models;

use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use tests\Feature\Models\Abstract\BaseModelFeatureTestContract;
use Tests\TestCase;

class OrderModelFeatureTest extends TestCase implements BaseModelFeatureTestContract
{
    public function testCreateAndFind(): void
    {
        $order = Order::factory()->create();

        $retrievedOrder = Order::findOrFail($order->id);

        $this->assertEquals($order->id, $retrievedOrder->id);
        $this->assertEquals($order->restaurant_id, $retrievedOrder->restaurant_id);
        $this->assertEquals($order->created_by, $retrievedOrder->created_by);
        $this->assertEquals($order->status, $retrievedOrder->status);
        $this->assertEquals($order->total, $retrievedOrder->total);
        $this->assertEquals(7, $retrievedOrder->table_number);
        $this->assertEquals('Extra ketchup', $retrievedOrder->notes);
    }

    public function testUpdate(): void
    {
        $order = Order::factory()->create();

        $order->update([
            'table_number' => 8,
            'notes' => 'Extra mayo',
        ]);

        $retrievedOrder = Order::findOrFail($order->id);

        $this->assertEquals($order->id, $retrievedOrder->id);
        $this->assertEquals($order->restaurant_id, $retrievedOrder->restaurant_id);
        $this->assertEquals($order->created_by, $retrievedOrder->created_by);
        $this->assertEquals($order->status, $retrievedOrder->status);
        $this->assertEquals($order->total, $retrievedOrder->total);
        $this->assertEquals(8, $retrievedOrder->table_number);
        $this->assertEquals('Extra mayo', $retrievedOrder->notes);
    }

    public function testDelete(): void
    {
        $order = Order::factory()->create();

        $order->delete();

        $this->assertNull(Order::find($order->id));
    }

    public function testFindAll(): void
    {
        Order::factory(10)->create();

        $orders = Order::all();

        $this->assertCount(10, $orders);
    }

    public function testFindAllWhere(): void
    {
        Order::factory(10)->create();

        Order::factory()->create([
            'table_number' => 99,
        ]);

        $orders = Order::where('table_number', 99)->get();

        $this->assertCount(1, $orders);
    }
}
