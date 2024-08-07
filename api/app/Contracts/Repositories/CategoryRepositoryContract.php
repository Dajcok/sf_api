<?php
namespace App\Contracts\Repositories;

use App\Models\Category;

interface CategoryRepositoryContract extends RepositoryContract
{
    /**
     * @param array $data
     * @return Category
     */
    public function create(array $data): Category;

    /**
     * @param int $id
     * @param array $data
     * @return Category
     */
    public function update(int $id, array $data): Category;

    /**
     * @param int $id
     * @return Category
     */
    public function find(int $id): Category;
}
