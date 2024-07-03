<?php

namespace App\DTO\Input\Auth;

/*
 * JWT token is created from this data
 */
class AuthTokenClaimsData
{
    public string $email;
    public string $id;

    public function __construct(string $email, string $id)
    {
        $this->email = $email;
        $this->id = $id;
    }
}
