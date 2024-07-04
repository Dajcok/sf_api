<?php

namespace App\DTO\Input\Auth;

/*
 * JWT token is created from this data
 */
class AuthTokenClaimsData
{
    public string $email;
    public int $id;

    public function __construct(string $email, int $id)
    {
        $this->email = $email;
        $this->id = $id;
    }
}
