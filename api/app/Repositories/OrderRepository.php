<?php

namespace App\Repositories;

use App\Contracts\Repositories\OrderRepositoryContract;
use App\Models\Order;

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
}
