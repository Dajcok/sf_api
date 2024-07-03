<?php

namespace App\DTO\Output;

/*
 * Used to represent the data of a User
 * Returned in all CRUD operations on the User
 */
class UserOutputData
{
    public string $id;
    public string $created_at;
    public string $updated_at;
    public string $name;
    public string $email;
    public string $email_verified_at;
    public string $role;
}
