<?php

namespace App\Repositories;

use App\Contracts\Repositories\ItemRepositoryContract;
use App\Models\Item;

/**
 * @extends Repository<Item>
 */
class ItemRepository extends Repository implements ItemRepositoryContract
{
    public function __construct(Item $model)
    {
        parent::__construct($model);
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $data): Item
    {
        return parent::create($data);
    }

    /**
     * {@inheritDoc}
     */
    public function update(int $id, array $data): Item
    {
        return parent::update($id, $data);
    }

    /**
     * {@inheritDoc}
     */
    public function find(int $id): Item
    {
        return parent::find($id);
    }
}
