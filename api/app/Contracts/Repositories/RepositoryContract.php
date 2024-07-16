<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Interface RepositoryContract
 * @package app\Contracts\Repositories
 * @template T of Model
 */
interface RepositoryContract
{
    /**
     * @return Collection<int, T>
     */
    public function all(): Collection;


    /**
     * @param int $id
     *
     * @throws ModelNotFoundException
     * @return T
     */
    public function find(int $id): Model;

    /**
     * @param array $data
     *
     * @return T
     */

    public function create(array $data): Model;


    /**
     * @param int $id
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
}
