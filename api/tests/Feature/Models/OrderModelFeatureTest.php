<?php

namespace tests\Feature\Models;

use App\Models\Order;
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
        $this->assertEquals('Extra ketchup', $retrievedOrder->notes);
    }

    public function testUpdate(): void
    {
        $order = Order::factory()->create();

        $order->update([
            'notes' => 'Extra mayo',
        ]);

        $retrievedOrder = Order::findOrFail($order->id);

        $this->assertEquals($order->id, $retrievedOrder->id);
        $this->assertEquals($order->restaurant_id, $retrievedOrder->restaurant_id);
        $this->assertEquals($order->created_by, $retrievedOrder->created_by);
        $this->assertEquals($order->status, $retrievedOrder->status);
        $this->assertEquals($order->total, $retrievedOrder->total);
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
            'notes' =>  'Random',
        ]);

        $orders = Order::where('notes', '=', 'Random')->get();

        $this->assertCount(1, $orders);
    }
}
