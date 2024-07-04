<?php

namespace app\DTO\Output\Abstract;

/*
 * Used to represent the data of a Model
 * Returned in all CRUD operations on the Model
 */

use JsonSerializable;

abstract class BaseModelOutputData implements JsonSerializable
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

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): string
    {
        return json_encode([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ]);
    }
}
