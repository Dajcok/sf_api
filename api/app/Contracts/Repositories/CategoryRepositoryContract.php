<?php
namespace App\Contracts\Repositories;

use App\Models\Category;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;

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

    /**
     * @return Eloquent|Builder
     */
    public function withPermissions(): Eloquent|Builder;
}
