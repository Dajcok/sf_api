<?php

namespace App\Services;

use App\Contracts\AuthServiceInterface;
use App\DTO\Input\AuthTokenInputData;
use App\DTO\Input\RefreshTokenInputData;
use App\DTO\Input\UserChangePasswordInputData;
use App\DTO\Input\UserCreateInputData;
use App\DTO\Input\UserForgotPasswordInputData;
use App\DTO\Input\UserLoginInputData;
use App\DTO\Input\UserResetPasswordInputData;
use App\DTO\Input\UserVerifyEmailInputData;
use App\DTO\Output\AuthenticatedOutputData;
use App\Exceptions\Api\BadRequest;
use App\Exceptions\Api\Unauthorized;
use App\Models\User;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Redis;

class AuthService implements AuthServiceInterface
{
    /**
     * {@inheritDoc}
     */
    public function register(UserCreateInputData $payload): AuthenticatedOutputData
    {
        try {
            $user = User::create([
                'name' => $payload->name,
                'email' => $payload->email,
                'password' => Hash::make($payload->password),
            ]);

            $tokenData = new AuthTokenInputData(email: $user->email, id: $user->id);

            $accessToken = JWTAuth::claims(['email' => $tokenData->email, 'id' => $tokenData->id])->fromUser($user);
            $refreshToken = JWTAuth::claims(['email' => $tokenData->email, 'id' => $tokenData->id])->fromUser($user);

            // Store for 7 days
            Redis::connection()->set('refresh_token_usr:' . $user->id, $refreshToken, 'EX', 604800);

            return new AuthenticatedOutputData(accessToken: $accessToken, refreshToken: $refreshToken);
        } catch (QueryException $e) {
            //Unique constraint violation
            if ($e->errorInfo[1] == 1062) {
                throw new BadRequest('User with this email already exists.');
            }

            throw $e;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function login(UserLoginInputData $payload): AuthenticatedOutputData
    {
        $credentials = [
            'email' => $payload->email,
            'password' => $payload->password,
        ];

        if (!$token = JWTAuth::attempt($credentials)) {
            throw new Unauthorized();
        }

        return new AuthenticatedOutputData(accessToken: $token, refreshToken: $token);
    }

    /**
     * {@inheritDoc}
     */
    public function refreshToken(RefreshTokenInputData $payload): AuthenticatedOutputData
    {
        $userId = Redis::connection()->get('refresh_token_usr:' . $payload->usr->id);

        if (!$userId) {
            throw new Unauthorized('Invalid or expired refresh token');
        }

        $user = User::find($userId);

        $tokenData = new AuthTokenInputData($user->email, (string)$user->id);

        $newAccessToken = JWTAuth::claims(['email' => $tokenData->email, 'id' => $tokenData->id])->fromUser($user);
        $newRefreshToken = JWTAuth::claims(['email' => $tokenData->email, 'id' => $tokenData->id])->fromUser($user);

        // Aktualizácia refresh tokenu v Redis
        Redis::connection()->command('DEL', ['refresh_token:' . $payload->refreshToken]);
        Redis::connection()->set('refresh_token:' . $newRefreshToken, $user->id, 'EX', 604800);

        return new AuthenticatedOutputData($newAccessToken, $newRefreshToken);
    }

    /**
     * {@inheritDoc}
     */
    public function logout(string $userId)
    {
        Redis::connection()->command('DEL', ['refresh_token_usr:' . $userId]);
    }

    /**
     * {@inheritDoc}
     */
    public function changePassword(UserChangePasswordInputData $payload)
    {
        // TODO: Implement changePassword() method.
    }

    /**
     * {@inheritDoc}
     */
    public function forgotPassword(string $email)
    {
        // TODO: Implement forgotPassword() method.
    }

    /**
     * {@inheritDoc}
     */
    public function resetPassword(UserResetPasswordInputData $payload)
    {
        // TODO: Implement resetPassword() method.
    }

    /**
     * {@inheritDoc}
     */
    public function verifyEmail(UserVerifyEmailInputData $payload)
    {
        // TODO: Implement verifyEmail() method.
    }
}
