<?php

namespace App\Repositories;

use App\Contracts\Repositories\CategoryRepositoryContract;
use App\Models\Category;

/**
 * @extends Repository<Category>
 */
class CategoryRepository extends Repository implements CategoryRepositoryContract
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $data): Category
    {
        return parent::create($data);
    }

    /**
     * {@inheritDoc}
     */
    public function update(int $id, array $data): Category
    {
        return parent::update($id, $data);
    }

    /**
     * {@inheritDoc}
     */
    public function find(int $id): Category
    {
        return parent::find($id);
    }
}
