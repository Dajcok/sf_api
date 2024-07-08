<?php

namespace Tests\Unit\Services;

use app\Contracts\Services\AuthServiceContract;
use App\DTO\Input\Auth\RefreshTokenInputData;
use App\DTO\Input\Auth\UserCreateInputData;
use App\DTO\Input\Auth\UserLoginInputData;
use App\DTO\Output\AuthenticatedOutputData;
use App\Exceptions\Api\Unauthorized;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\UserService;
use Doctrine\DBAL\Query\QueryException;
use Tests\Mocks\Models\UserModelMock;
use tests\TestCase;

class AuthServiceTest extends TestCase
{
    private AuthServiceContract $service;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new AuthService(new UserService(new UserRepository(UserModelMock::create())));
    }

    /**
     * @throws QueryException
     */
    public function testRegister(): void
    {
        $payload = new UserCreateInputData(name: 'John Doe', email: 'test@example.com', password: 'password123');
        $result = $this->service->register($payload);

        $this->assertInstanceOf(AuthenticatedOutputData::class, $result);
        $this->assertNotEmpty($result->accessToken);
        $this->assertNotEmpty($result->refreshToken);
    }

    /**
     * @throws Unauthorized
     */
    public function testLogin(): void
    {
        $payload = new UserLoginInputData(email: 'test@example.com', password: 'password123');
        $result = $this->service->login($payload);

        $this->assertInstanceOf(AuthenticatedOutputData::class, $result);
        $this->assertNotEmpty($result->accessToken);
        $this->assertNotEmpty($result->refreshToken);
    }

    /**
     * @throws Unauthorized
     */
    public function testRefreshToken(): void
    {
        $payload = new UserLoginInputData(email: 'test@example.com', password: 'password123');
        $loginResult = $this->service->login($payload);

        $refreshPayload = new RefreshTokenInputData(refreshToken: $loginResult->refreshToken);
        $result = $this->service->refreshToken($refreshPayload);

        $this->assertInstanceOf(AuthenticatedOutputData::class, $result);
        $this->assertNotEmpty($result->accessToken);
        $this->assertNotEmpty($result->refreshToken);
    }

    /**
     * @throws Unauthorized
     */
    public function testInvalidLogin(): void
    {
        $this->expectException(Unauthorized::class);

        $payload = new UserLoginInputData(email: 'invalid@example.com', password: 'invalidpassword');
        $this->service->login($payload);
    }

    /**
     * @throws Unauthorized
     */
    public function testInvalidRefreshToken(): void
    {
        $this->expectException(Unauthorized::class);

        $payload = new RefreshTokenInputData(refreshToken: 'invalidtoken');
        $this->service->refreshToken($payload);
    }
}
