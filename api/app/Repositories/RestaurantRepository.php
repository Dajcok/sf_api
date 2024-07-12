<?php

namespace App\Repositories;

use App\Contracts\Repositories\RestaurantRepositoryContract;
use App\Models\Restaurant;

/**
 * @extends Repository<Restaurant>
 */
class RestaurantRepository extends Repository implements RestaurantRepositoryContract
{
    public function __construct(Restaurant $model)
    {
        parent::__construct($model);
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $data): Restaurant
    {
        return parent::create($data);
    }

    /**
     * {@inheritDoc}
     */
    public function update(int $id, array $data): Restaurant
    {
        return parent::update($id, $data);
    }

    /**
     * {@inheritDoc}
     */
    public function find(int $id): Restaurant
    {
        return parent::find($id);
    }
}
