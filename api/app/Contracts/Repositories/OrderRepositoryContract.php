<?php

namespace App\Contracts\Repositories;

use App\Models\Order;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Interface OrderRepositoryContract
 * @package App\Contracts\Repositories
 * @extends RepositoryContract<Order>
 */
interface OrderRepositoryContract extends RepositoryContract
{
    /**
     * @param array $data
     * @return Order
     */
    public function create(array $data): Order;

    /**
     * @param int $id
     * @param array $data
     * @return Order
     */
    public function update(int $id, array $data): Order;

    /**
     * @param int $id
     * @return Order
     */
    public function find(int $id): Order;

    /**
     * @param int   $orderId
     * @param array $items
     * @return Order
     * @throws ModelNotFoundException
     */
    public function addItemsToOrder(int $orderId, array $items): Order;

    /**
     * Specify how the app should retrieve records for specific user.
     *
     * @return Eloquent|Builder
     */
    public function withPermissions(): Eloquent|Builder;
}
