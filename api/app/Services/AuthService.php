<?php

namespace App\Services;

use App\Contracts\Repositories\UserRepositoryContract;
use App\Contracts\Services\AuthServiceContract;
use App\DTO\Input\Auth\AuthTokenClaimsData;
use App\DTO\Input\Auth\RefreshTokenInputData;
use App\DTO\Input\Auth\UserCreateInputData;
use App\DTO\Input\Auth\UserLoginInputData;
use App\DTO\Output\AuthenticatedOutputData;
use App\Enums\UserRoleEnum;
use App\Exceptions\Api\Unauthorized;
use App\Models\Restaurant;
use App\Models\User;
use Auth;
use Exception;
use Illuminate\Redis\Connections\PhpRedisConnection;
use Illuminate\Support\Facades\Redis;
use Log;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
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
    private function generateTokenFromUser(JWTSubject $user): string
    {
        $claimsData = new AuthTokenClaimsData(email: $user->email, id: $user->id);
        return JWTAuth::claims(['email' => $claimsData->email, 'id' => $claimsData->id])->fromUser($user);
    }

    /**
     * Generate refresh token.
     *
     * @return string
     * @throws Exception
     */
    private function generateRefreshToken(): string
    {
        if (config('app.env') === 'testing') {
            return 'mocked_token';
        }

        return bin2hex(random_bytes(40));
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
        $redisConnection->set('refresh_token_usr:' . $userId, $refreshToken, 'EX', config('jwt.refresh_ttl') * 60);
    }

    /**
     * {@inheritDoc}
     * @throws Exception
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
        $refreshToken = $this->generateRefreshToken();

        $this->storeRefreshToken($refreshToken, $user->id);

        return new AuthenticatedOutputData(accessToken: $accessToken, refreshToken: $refreshToken);
    }

    /**
     * {@inheritDoc}
     * @throws Exception
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
        $refreshToken = $this->generateRefreshToken();

        $this->storeRefreshToken($refreshToken, $user->id);

        return new AuthenticatedOutputData(
            accessToken: $accessToken,
            refreshToken: $refreshToken,
        );
    }

    /**
     * {@inheritDoc}
     * @throws Exception
     */
    public function refreshToken(RefreshTokenInputData $payload): AuthenticatedOutputData
    {
        /**
         * @var User $user
         */
        $user = JWTAuth::user();
        $currentStoredToken = Redis::connection('default')->get('refresh_token_usr:' . $user->id);

        if (!$currentStoredToken || $currentStoredToken !== $payload->refreshToken) {
            throw new TokenInvalidException('Invalid or expired refresh token');
        }

        $newAccessToken = $this->generateTokenFromUser($user);
        $newRefreshToken = $this->generateRefreshToken();

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

    /**
     * @throws Exception
     */
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
            'role' => UserRoleEnum::CUSTOMER->value,
            'email' => $email,
            'password' => $password,
        ]);

        $accessToken = $this->generateTokenFromUser($anonymousUser);
        $refreshToken = $this->generateRefreshToken();

        $this->storeRefreshToken($refreshToken, $anonymousUser->id);

        return new AuthenticatedOutputData(accessToken: $accessToken, refreshToken: $refreshToken);
    }
}
