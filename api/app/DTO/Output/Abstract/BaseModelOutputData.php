<?php

namespace App\DTO\Output\Abstract;

use App\Contracts\DTO\ArrayableContract;

/*
 * Used to represent the data of a Model
 * Returned in all CRUD operations on the Model
 */
abstract class BaseModelOutputData implements ArrayableContract
{
    public int $id;
    public string $created_at;
    public string $updated_at;

    public function __construct(int $id, string $created_at, string $updated_at)
    {
        $this->id = $id;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
