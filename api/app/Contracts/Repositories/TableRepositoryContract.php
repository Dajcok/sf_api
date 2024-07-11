<?php

namespace app\Contracts\Repositories;

use App\Models\Table;

interface TableRepositoryContract extends RepositoryContract
{
    /**
     * @param array $data
     * @return Table
     */
    public function create(array $data): Table;

    /**
     * @param int $id
     * @param array $data
     * @return Table
     */
    public function update(int $id, array $data): Table;

    /**
     * @param int $id
     * @return Table
     */
    public function find(int $id): Table;
}
