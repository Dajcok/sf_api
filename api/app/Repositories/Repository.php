<?php

namespace App\Repositories;

use App\Contracts\Repositories\RepositoryContract;
use Eloquent;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * @template T of Model
 * @implements RepositoryContract<T>
 */
abstract class Repository implements RepositoryContract
{
    /**
     * @var T
     */
    protected Model $model;

    /**
     * @param T $model
     */
    public function __construct($model)
    {
        $this->model = $model;
    }

    /**
     * {@inheritDoc}
     */
    public function all($paginated = true): LengthAwarePaginator
    {
        if (!$paginated) {
            return $this->model->all();
        }

        return $this->paginate($this->model);
    }

    /**
     * {@inheritDoc}
     */
    public function find(int $id): Model
    {
        return $this->model->findOrFail($id);
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    /**
     * {@inheritDoc}
     */
    public function update(int $id, array $data): Model
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);
        return $model->refresh();
    }

    /**
     * {@inheritDoc}
     */
    public function delete(int $id): int
    {
        return $this->model->destroy($id);
    }

    /**
     * {@inheritDoc}
     */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * {@inheritDoc}
     */
    public function paginate(Eloquent|Builder $model, int $perPage = null): LengthAwarePaginator
    {
        $perPage = $perPage ?? config('app.pagination.default');
        return $model->paginate($perPage);
    }
}
