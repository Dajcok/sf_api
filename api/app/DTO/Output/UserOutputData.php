<?php

namespace App\DTO\Output;

/*
 * Used to represent the data of a User
 * Returned in all CRUD operations on the User
 */
class UserOutputData extends BaseOutputData
{
    public string $name;
    public string $email;
    public string $email_verified_at;
    public string $role;
}
