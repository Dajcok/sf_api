<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryContract;
use App\Contracts\Services\AuthServiceContract;
use App\DTO\Input\Auth\AuthTokenClaimsData;
use App\DTO\Input\Auth\RefreshTokenInputData;
use App\DTO\Input\Auth\UserCreateInputData;
use App\DTO\Input\Auth\UserLoginInputData;
use App\DTO\Output\AuthenticatedOutputData;
use App\Exceptions\Api\Unauthorized;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Redis\Connections\PhpRedisConnection;
use Illuminate\Support\Facades\Redis;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Service responsible for authentication logic using JWT.
 */
readonly class AuthService implements AuthServiceContract
{
    public function __construct(private UserRepositoryContract $userRepository)
    {
    }

    /**
     * Generate JWT token from user claims.
     * Claims object is defined by AuthTokenClaimsData.
     *
     *
     * @param User $user
     * @return string
     * @see AuthTokenClaimsData
     */
    private function generateTokenFromUser(User $user): string
    {
        $claimsData = new AuthTokenClaimsData(email: $user->email, id: $user->id);
        return JWTAuth::claims(['email' => $claimsData->email, 'id' => $claimsData->id])->fromUser($user);
    }

    /**
     * @param string $refreshToken
     * @param int    $userId
     * @return void
     */
    private function storeRefreshToken(string $refreshToken, int $userId): void
    {
        /**
         * @var PhpRedisConnection $redisConnection
         */
        $redisConnection = Redis::connection('default');
        $redisConnection->set('refresh_token_usr:' . $userId, $refreshToken, 'EX', 604800);
    }

    /**
     * {@inheritDoc}
     */
    public function register(UserCreateInputData $payload): AuthenticatedOutputData
    {
        $restaurant = Restaurant::create([
            'name' => $payload->name . ' Restaurant',
            'formatted_address' => '',
        ]);

        $user = $this->userRepository->create([
            ...get_object_vars($payload),
            'restaurant_id' => $restaurant->id
        ]);

        $accessToken = $this->generateTokenFromUser($user);
        $refreshToken = $this->generateTokenFromUser($user);

        $this->storeRefreshToken($refreshToken, $user->id);

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

        /**
         * @var User $user
         */
        $user = JWTAuth::user();
        $refreshToken = $this->generateTokenFromUser($user);

        $this->storeRefreshToken($refreshToken, $user->id);

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
        $user = $this->userRepository->find($userId);

        $currentStoredToken = Redis::connection('default')->get('refresh_token_usr:' . $user->id);

        if (!$currentStoredToken) {
            throw new Unauthorized('Invalid or expired refresh token');
        }

        if ($currentStoredToken !== $payload->refreshToken) {
            throw new Unauthorized('Invalid or expired refresh token');
        }

        $newAccessToken = $this->generateTokenFromUser($user);
        $newRefreshToken = $this->generateTokenFromUser($user);

        // Aktualizácia refresh tokenu v Redis
        Redis::connection('default')->command('DEL', ['refresh_token_usr:' . $user->id]);
        $this->storeRefreshToken($newRefreshToken, $user->id);

        return new AuthenticatedOutputData($newAccessToken, $newRefreshToken);
    }

    /**
     * {@inheritDoc}
     */
    public function logout(int $userId)
    {
        Redis::connection('default')->command('DEL', ['refresh_token_usr:' . $userId]);
    }

    public function createCustomer(): AuthenticatedOutputData
    {
        $email = uniqid() . config('auth.anonymous_user_email_postfix', '@example.com');
        $password = uniqid();

        //So we can mock this call easily in tests
        if (config('app.env') === 'testing') {
            $email = 'customer@mocking.sk';
            $password = 'StrongPWD';
        }

        $anonymousUser = $this->userRepository->create([
            'is_anonymous' => true,
            'role' => 'CUSTOMER',
            'email' => $email,
            'password' => $password,
        ]);

        $accessToken = $this->generateTokenFromUser($anonymousUser);
        $refreshToken = $this->generateTokenFromUser($anonymousUser);

        $this->storeRefreshToken($refreshToken, $anonymousUser->id);

        return new AuthenticatedOutputData(accessToken: $accessToken, refreshToken: $refreshToken);
    }
}
