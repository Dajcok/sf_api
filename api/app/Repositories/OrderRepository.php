<?php

namespace App\Repositories;

use App\Contracts\Repositories\OrderRepositoryContract;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

/**
 * @extends Repository<Order>
 */
class OrderRepository extends Repository implements OrderRepositoryContract
{
    public function __construct(Order $model)
    {
        parent::__construct($model);
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $data): Order
    {
        return parent::create($data);
    }

    /**
     * {@inheritDoc}
     */
    public function update(int $id, array $data): Order
    {
        return parent::update($id, $data);
    }

    /**
     * {@inheritDoc}
     */
    public function find(int $id): Order
    {
        return parent::find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function addItemsToOrder(int $orderId, array $items): Order
    {
        $order = $this->find($orderId);

        $orderItems = [];
        foreach ($items as $item) {
            $orderItems[$item['item_id']] = ['qty' => $item['qty']];
        }

        $order->items()->sync($orderItems);

        return $order->refresh();
    }
}
