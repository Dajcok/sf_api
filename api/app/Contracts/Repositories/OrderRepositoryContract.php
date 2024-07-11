<?php

namespace app\Contracts\Repositories;

use App\Models\Order;

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
}
