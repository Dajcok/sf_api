<?php

namespace App\Services\Abstract;

use app\Contracts\Repositories\RepositoryContract;
use app\Contracts\Services\Abstract\CrudServiceContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

/**
 * You can override these methods in the child classes to inject business logic.
 * Business logic overriden using these methods has to be responsible only for
 * the current model.If you need to work with multiple models, you should create
 * a new service implementing child CrudService services using DI.
 *
 * @template TModel of Model
 * @template TRepository of RepositoryContract
 */
readonly abstract class CrudService implements CrudServiceContract
{
    /**
     * @param TRepository $repository
     */
    public function __construct(
        protected RepositoryContract $repository
    ) {
    }

    /**
     * @return Collection<int, TModel>
     */
    public function all(): Collection
    {
        return $this->repository->all();
    }

    /**
     * @param int $id
     * @return TModel
     */
    public function find(int $id): Model
    {
        return $this->repository->find($id);
    }

    /**
     * @param array $data
     * @return TModel
     */
    public function create(array $data): Model
    {
        return $this->repository->create($data);
    }

    /**
     * @param int   $id
     * @param array $data
     * @return TModel
     */
    public function update(int $id, array $data): Model
    {
        return $this->repository->update($id, $data);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        return $this->repository->delete($id);
    }

    /**
     * @return TRepository
     */
    public function getRepository(): RepositoryContract
    {
        return $this->repository;
    }
}
