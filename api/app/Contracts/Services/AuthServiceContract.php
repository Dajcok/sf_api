<?php

namespace app\Contracts\Services;

use App\DTO\Input\Auth\RefreshTokenInputData;
use App\DTO\Input\Auth\UserChangePasswordInputData;
use App\DTO\Input\Auth\UserCreateInputData;
use App\DTO\Input\Auth\UserLoginInputData;
use App\DTO\Input\Auth\UserResetPasswordInputData;
use App\DTO\Input\Auth\UserVerifyEmailInputData;
use App\DTO\Output\AuthenticatedOutputData;
use App\Exceptions\Api\BadRequest;
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
     * @param string $userId
     */
    public function logout(string $userId);

    /**
     * Change the user password
     *
     * @param UserChangePasswordInputData $payload
     */
    public function changePassword(UserChangePasswordInputData $payload);

    /**
     * Send a forgot password email
     *
     * @param string $email
     */
    public function forgotPassword(string $email);

    /**
     * Reset the user password
     *
     * @param UserResetPasswordInputData $payload
     */
    public function resetPassword(UserResetPasswordInputData $payload);

    /**
     * Verify the user email
     *
     * @param UserVerifyEmailInputData $payload
     */
    public function verifyEmail(UserVerifyEmailInputData $payload);
}
