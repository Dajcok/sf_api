<?php

namespace App\DTO\Output;

/*
 * Used to represent the data of a User
 * Returned in all CRUD operations on the User
 */

use app\DTO\Output\Abstract\BaseModelOutputData;
use JsonSerializable;

class UserOutputData extends BaseModelOutputData
{
    public string $name;
    public string $email;
    public ?string $email_verified_at;
    public ?string $role;

    public function __construct(
        int $id,
        string $created_at,
        string $updated_at,
        string $name,
        string $email,
        ?string $email_verified_at = null,
        ?string $role = null
    ) {
        parent::__construct(id: $id, created_at: $created_at, updated_at: $updated_at);

        $this->name = $name;
        $this->email = $email;
        $this->email_verified_at = $email_verified_at;
        $this->role = $role;
    }

    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            ...parent::toArray(),

            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'role' => $this->role
        ];
    }
}
