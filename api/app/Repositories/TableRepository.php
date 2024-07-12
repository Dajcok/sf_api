<?php

namespace App\Repositories;

use App\Contracts\Repositories\TableRepositoryContract;
use App\Models\Table;

/**
 * @extends Repository<Table>
 */
class TableRepository extends Repository implements TableRepositoryContract
{
    public function __construct(Table $model)
    {
        parent::__construct($model);
    }

    /**
     * {@inheritDoc}
     */
    public function create(array $data): Table
    {
        return parent::create($data);
    }

    /**
     * {@inheritDoc}
     */
    public function update(int $id, array $data): Table
    {
        return parent::update($id, $data);
    }

    /**
     * {@inheritDoc}
     */
    public function find(int $id): Table
    {
        return parent::find($id);
    }
}
