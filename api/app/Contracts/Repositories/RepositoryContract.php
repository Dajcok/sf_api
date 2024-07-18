<?php

namespace App\Contracts\Repositories;

use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Interface RepositoryContract
 *
 * @package app\Contracts\Repositories
 * @template T of Model
 */
interface RepositoryContract
{
    /**
     * @param bool $paginated
     * @return Collection | LengthAwarePaginator
     */
    public function all(bool $paginated): Collection|LengthAwarePaginator;


    /**
     * @param int $id
     *
     * @return T
     * @throws ModelNotFoundException
     */
    public function find(int $id): Model;

    /**
     * @param array $data
     *
     * @return T
     */

    public function create(array $data): Model;


    /**
     * @param int   $id
     * @param array $data
     *
     * @return T
     */
    public function update(int $id, array $data): Model;

    /**
     * @param int $id
     *
     * @return int
     */
    public function delete(int $id): int;

    /**
     * @return T
     */
    public function getModel(): Model;

    /**
     * Paginate the model results.
     *
     * @param Eloquent|Builder $model
     * @param int|null         $perPage
     * @return LengthAwarePaginator
     */
    public function paginate(Eloquent|Builder $model, int $perPage = null): LengthAwarePaginator;
}
