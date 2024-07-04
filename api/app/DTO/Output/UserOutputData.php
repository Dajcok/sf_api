<?php

namespace App\DTO\Output;

/*
 * Used to represent the data of a User
 * Returned in all CRUD operations on the User
 */

use app\DTO\Output\Abstract\BaseModelOutputData;
use JsonSerializable;

class UserOutputData extends BaseModelOutputData implements JsonSerializable
{
    public string $name;
    public string $email;
    public string $email_verified_at;
    public ?string $role;

    /**
     * @inheritDoc
     */
    public function jsonSerialize(): string
    {
        return json_encode([
            ...parent::jsonSerialize(),

            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at' => $this->email_verified_at,
            'role' => $this->role
        ]);
    }
}
