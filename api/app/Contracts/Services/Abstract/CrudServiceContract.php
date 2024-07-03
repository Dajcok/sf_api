<?php

namespace app\Contracts\Services\Abstract;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

interface CrudServiceContract
{
    /**
     * Get all records
     *
     * @return Collection
     */
    public function all(): Collection;

    /**
     * Get a record by id
     *
     * @param int $id
     * @return Model
     */
    public function find(int $id): Model;

    /**
     * Create a record
     *
     * @param array $data
     * @return Model
     */
    public function create(array $data): Model;

    /**
     * Update a record
     *
     * @param int $id
     * @param array $data
     * @return Model
     */
    public function update(int $id, array $data): Model;

    /**
     * Delete a record
     *
     * @param int $id
     * @return true
     */
    public function delete(int $id): true;
}
