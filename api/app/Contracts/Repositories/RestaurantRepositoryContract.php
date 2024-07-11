<?php

namespace app\Contracts\Repositories;

use App\Models\Restaurant;

interface RestaurantRepositoryContract extends RepositoryContract
{
    /**
     * @param array $data
     * @return Restaurant
     */
    public function create(array $data): Restaurant;

    /**
     * @param int $id
     * @param array $data
     * @return Restaurant
     */
    public function update(int $id, array $data): Restaurant;

    /**
     * @param int $id
     * @return Restaurant
     */
    public function find(int $id): Restaurant;
}
