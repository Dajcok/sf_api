<?php

namespace App\Contracts\Repositories;

use App\Models\Restaurant;

/**
 * Interface RestaurantRepositoryContract
 * @package App\Contracts\Repositories
 * @extends RepositoryContract<Restaurant>
 */
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
