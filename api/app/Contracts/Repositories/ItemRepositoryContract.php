<?php

namespace App\Contracts\Repositories;

use App\Models\Item;

/**
 * Interface ItemRepositoryContract
 * @package App\Contracts\Repositories
 * @extends RepositoryContract<Item>
 */
interface ItemRepositoryContract extends RepositoryContract
{
    /**
     * @param array $data
     * @return Item
     */
    public function create(array $data): Item;

    /**
     * @param int $id
     * @param array $data
     * @return Item
     */
    public function update(int $id, array $data): Item;

    /**
     * @param int $id
     * @return Item
     */
    public function find(int $id): Item;
}
