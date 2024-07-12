<?php

namespace App\Contracts\Services;

use App\DTO\Input\Auth\RefreshTokenInputData;
use App\DTO\Input\Auth\UserCreateInputData;
use App\DTO\Input\Auth\UserLoginInputData;
use App\DTO\Output\AuthenticatedOutputData;
use App\Exceptions\Api\Unauthorized;
use Doctrine\DBAL\Query\QueryException;

interface AuthServiceContract
{
    /**
     * Creates a user with hashed pwd and returns the access and refresh tokens.
     * Refresh token is cached in Redis.
     * User claims are email and id.
     *
     * throws BadRequest if user with the email already exists.
     * throws QueryException if creating the user fails for any other reason.
     *
     * @param UserCreateInputData $payload
     * @return AuthenticatedOutputData
     * @throws QueryException - if creating the user fails
     */
    public function register(UserCreateInputData $payload): AuthenticatedOutputData;

    /**
     * Logs in the user and returns the access and refresh tokens.
     *
     * @param UserLoginInputData $payload
     * @return AuthenticatedOutputData
     * @throws Unauthorized
     */
    public function login(UserLoginInputData $payload): AuthenticatedOutputData;

    /**
     * Creates new access and refresh tokens using the refresh token.
     * New refresh token is cached in Redis and old is removed.
     *
     * @param RefreshTokenInputData $payload
     * @return AuthenticatedOutputData
     * @throws Unauthorized
     */
    public function refreshToken(RefreshTokenInputData $payload): AuthenticatedOutputData;

    /**
     * Removes the refresh token from Redis. Cookie deletion is handled by controller.
     *
     * @param int $userId
     */
    public function logout(int $userId);

    /**
     * Creates a new anonymous user and returns the access and refresh tokens.
     *
     * @return AuthenticatedOutputData
     */
    public function createCustomer(): AuthenticatedOutputData;
}
