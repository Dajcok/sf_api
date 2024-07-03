<?php

namespace App\Services;

use App\Contracts\Services\AuthServiceContract;
use App\DTO\Input\Auth\AuthTokenClaimsData;
use App\DTO\Input\Auth\RefreshTokenInputData;
use App\DTO\Input\Auth\UserChangePasswordInputData;
use App\DTO\Input\Auth\UserCreateInputData;
use App\DTO\Input\Auth\UserLoginInputData;
use App\DTO\Input\Auth\UserResetPasswordInputData;
use App\DTO\Input\Auth\UserVerifyEmailInputData;
use App\DTO\Output\AuthenticatedOutputData;
use App\Exceptions\Api\Unauthorized;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redis;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService implements AuthServiceContract
{
    /**
     * Generate JWT token from user claims.
     * Claims object is defined by AuthTokenClaimsData.
     *
     *
     * @param User $user
     * @return string
     * @see AuthTokenClaimsData
     */
    private function generateTokenFromUser(JWTSubject $user): string
    {
        $claimsData = new AuthTokenClaimsData(email: $user->email, id: (string)$user->id);
        return JWTAuth::claims(['email' => $claimsData->email, 'id' => $claimsData->id])->fromUser($user);
    }

    /**
     * {@inheritDoc}
     */
    public function register(UserCreateInputData $payload): AuthenticatedOutputData
    {
        $user = User::create([
            'name' => $payload->name,
            'email' => $payload->email,
            'password' => Hash::make($payload->password),
        ]);

        $accessToken = $this->generateTokenFromUser($user);
        $refreshToken = $this->generateTokenFromUser($user);

        // Store for 7 days
        Redis::connection()->set('refresh_token_usr:' . $user->id, $refreshToken, 'EX', 604800);

        return new AuthenticatedOutputData(accessToken: $accessToken, refreshToken: $refreshToken);
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

        if (!$accessToken = JWTAuth::attempt($credentials)) {
            throw new Unauthorized("Invalid credentials");
        }

        $user = JWTAuth::user();
        $refreshToken = $this->generateTokenFromUser($user);

        return new AuthenticatedOutputData(
            accessToken: $accessToken,
            refreshToken: $refreshToken,
        );
    }

    /**
     * {@inheritDoc}
     */
    public function refreshToken(RefreshTokenInputData $payload): AuthenticatedOutputData
    {
        $tokenData = JWTAuth::setToken($payload->refreshToken)->getPayload();
        $userId = $tokenData->get('id');
        $user = User::find($userId);

        $currentStoredToken = Redis::connection()->get('refresh_token_usr:' . $user->id);

        if (!$currentStoredToken) {
            throw new Unauthorized('Invalid or expired refresh token');
        }

        if ($currentStoredToken !== $payload->refreshToken) {
            throw new Unauthorized('Invalid or expired refresh token');
        }

        $newAccessToken = $this->generateTokenFromUser($user);
        $newRefreshToken = $this->generateTokenFromUser($user);

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
